<?php

namespace App\Http\Controllers;

use App\Models\Disbursement;
use App\Models\DisbursementSchedule;
use App\Models\JitoJeapBank;
use App\Models\User;
use App\Models\ApplicationWorkflowStatus;
use App\Models\WorkingCommitteeApproval;
use App\Models\PdcDetail;
use App\Traits\LogsUserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DisbursementController extends Controller
{
    use LogsUserActivity;

    /**
     * Display the disbursement dashboard for Accounts Team - Shows list of students
     */
    public function index()
    {
        // Ensure disbursement schedules exist for apex_2 approved users
        $this->ensureDisbursementSchedulesExist();

        // Get aggregated student data with disbursement summaries
        // Get user IDs and schedules from admin_panel
        $scheduleData = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_installments'),
                DB::raw('SUM(planned_amount) as total_planned_amount')
            )
            ->groupBy('user_id')
            ->get();

        // Get disbursed amounts from admin_panel
        $disbursedData = DB::connection('admin_panel')
            ->table('disbursements')
            ->select('user_id', DB::raw('SUM(amount) as total_disbursed_amount'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Get status data from admin_panel - count completed schedules
        $statusData = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count')
            )
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Get disbursement counts per user (more reliable method)
        $disbursementCounts = DB::connection('admin_panel')
            ->table('disbursements')
            ->select('user_id', DB::raw('COUNT(*) as disbursement_count'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Get user names from default database
        $userIds = $scheduleData->pluck('user_id')->unique()->toArray();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        // Build student list
        $students = $scheduleData->map(function ($item) use ($disbursedData, $statusData, $disbursementCounts, $users) {
            $user = $users->get($item->user_id);
            $disbursed = $disbursedData->get($item->user_id);
            $statusInfo = $statusData->get($item->user_id);
            $disbursementCount = $disbursementCounts->get($item->user_id)->disbursement_count ?? 0;

            $totalDisbursedAmount = $disbursed->total_disbursed_amount ?? 0;
            $remainingAmount = $item->total_planned_amount - $totalDisbursedAmount;

            // Get schedule counts
            $totalCount = $statusInfo->total_count ?? 0;
            $completedCount = $statusInfo->completed_count ?? 0;

            // Determine status based on schedule completion
            // Method 1: Check if all schedules have status = 'completed'
            $allSchedulesCompleted = ($totalCount > 0 && $completedCount === $totalCount);

            // Method 2: Check if disbursement count equals schedule count (more reliable)
            $disbursementsMatchSchedules = ($totalCount > 0 && $disbursementCount === $totalCount);

            // Method 3: Check if disbursed amount equals or exceeds planned amount
            $amountFullyDisbursed = ($totalDisbursedAmount >= $item->total_planned_amount);

            // Status logic: use disbursement count as primary check
            if ($totalCount > 0 && $disbursementCount === $totalCount && $amountFullyDisbursed) {
                $status = 'completed';
            } elseif ($disbursementCount > 0 || $totalDisbursedAmount > 0) {
                $status = 'in_progress';
            } else {
                $status = 'pending';
            }

            return (object) [
                'user_id' => $item->user_id,
                'name' => $user ? $user->name : 'Unknown',
                'total_installments' => $item->total_installments,
                'total_planned_amount' => $item->total_planned_amount,
                'total_disbursed_amount' => $totalDisbursedAmount,
                'remaining_amount' => $remainingAmount,
                'status' => $status,
                'debug_total' => $totalCount,
                'debug_completed' => $completedCount,
                'debug_disbursement_count' => $disbursementCount
            ];
        })->sortBy('name')->values();

        // Calculate summary values
        $totalDisbursementAmount = $students->sum('total_planned_amount');
        $disbursedAmount = $students->sum('total_disbursed_amount');
        $remainingDisbursementAmount = $totalDisbursementAmount - $disbursedAmount;

        // Status counts
        $pendingCount = $students->where('status', 'pending')->count();
        $inProgressCount = $students->where('status', 'in_progress')->count();
        $completedCount = $students->where('status', 'completed')->count();

        return view('admin.disbursement.index', compact(
            'students',
            'totalDisbursementAmount',
            'disbursedAmount',
            'remainingDisbursementAmount',
            'pendingCount',
            'inProgressCount',
            'completedCount'
        ));
    }

    /**
     * Ensure disbursement schedules exist for apex_2 approved users
     */
    private function ensureDisbursementSchedulesExist()
    {
        // Get user IDs from default database who are approved by apex_2
        $approvedUserIds = DB::table('users')
            ->join('application_workflow_statuses', 'users.id', '=', 'application_workflow_statuses.user_id')
            ->where('application_workflow_statuses.apex_2_status', 'approved')
            ->pluck('users.id');

        foreach ($approvedUserIds as $userId) {
            // Get working committee approval for this user
            $wcApproval = DB::connection('admin_panel')
                ->table('working_committee_approvals')
                ->where('user_id', $userId)
                ->first();

            if (!$wcApproval) {
                continue;
            }

            // Get workflow status ID
            $workflowStatus = DB::table('application_workflow_statuses')
                ->where('user_id', $userId)
                ->first();

            if (!$workflowStatus) {
                continue;
            }

            // Check if schedules already exist for this user
            $existingSchedules = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->where('user_id', $userId)
                ->exists();

            if ($existingSchedules) {
                continue;
            }

            // Create disbursement schedules from WC approval data
            $this->createSchedulesFromWCApproval($userId, $wcApproval, $workflowStatus->id);
        }
    }

    /**
     * Create disbursement schedules from Working Committee approval
     */
    private function createSchedulesFromWCApproval($userId, $wcApproval, $workflowStatusId)
    {
        // Decode JSON arrays
        $yearlyDates = json_decode($wcApproval->yearly_dates, true) ?? [];
        $yearlyAmounts = json_decode($wcApproval->yearly_amounts, true) ?? [];
        $halfYearlyDates = json_decode($wcApproval->half_yearly_dates, true) ?? [];
        $halfYearlyAmounts = json_decode($wcApproval->half_yearly_amounts, true) ?? [];

        // Check for yearly disbursements
        if (!empty($yearlyDates) && !empty($yearlyAmounts)) {
            foreach ($yearlyDates as $index => $plannedDate) {
                $amount = $yearlyAmounts[$index] ?? 0;

                DB::connection('admin_panel')
                    ->table('disbursement_schedules')
                    ->insert([
                        'user_id' => $userId,
                        'workflow_status_id' => $workflowStatusId,
                        'installment_no' => $index + 1,
                        'planned_date' => $plannedDate,
                        'planned_amount' => $amount,
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            }
        }
        // Check for half-yearly disbursements
        elseif (!empty($halfYearlyDates) && !empty($halfYearlyAmounts)) {
            foreach ($halfYearlyDates as $index => $plannedDate) {
                $amount = $halfYearlyAmounts[$index] ?? 0;

                DB::connection('admin_panel')
                    ->table('disbursement_schedules')
                    ->insert([
                        'user_id' => $userId,
                        'workflow_status_id' => $workflowStatusId,
                        'installment_no' => $index + 1,
                        'planned_date' => $plannedDate,
                        'planned_amount' => $amount,
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            }
        }
        // Fallback to single installment amount
        elseif ($wcApproval->installment_amount > 0) {
            DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->insert([
                    'user_id' => $userId,
                    'workflow_status_id' => $workflowStatusId,
                    'installment_no' => 1,
                    'planned_date' => $wcApproval->repayment_starting_from,
                    'planned_amount' => $wcApproval->installment_amount,
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }
    }

    /**
     * Store a new disbursement
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'disbursement_schedule_id' => 'required',
            'disbursement_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'jito_jeap_bank_id' => 'required',
            'utr_number' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $logData = null;

            DB::transaction(function () use ($request, &$logData) {
                // Get schedule from admin_panel connection
                $schedule = DB::connection('admin_panel')
                    ->table('disbursement_schedules')
                    ->where('id', $request->disbursement_schedule_id)
                    ->first();

                if (!$schedule) {
                    throw new \Exception('Disbursement schedule not found');
                }

                // Check if disbursement already exists for this schedule
                $existingDisbursement = DB::connection('admin_panel')
                    ->table('disbursements')
                    ->where('disbursement_schedule_id', $request->disbursement_schedule_id)
                    ->first();

                if ($existingDisbursement) {
                    throw new \Exception('Disbursement already exists for this schedule');
                }

                // Validate amount doesn't exceed planned amount
                if ($request->amount > $schedule->planned_amount) {
                    throw new \Exception('Disbursement amount cannot exceed planned amount');
                }

                // Create the disbursement in admin_panel connection
                $disbursementId = DB::connection('admin_panel')
                    ->table('disbursements')
                    ->insertGetId([
                        'disbursement_schedule_id' => $request->disbursement_schedule_id,
                        'user_id' => $schedule->user_id,
                        'jito_jeap_bank_id' => $request->jito_jeap_bank_id,
                        'disbursement_date' => $request->disbursement_date,
                        'amount' => $request->amount,
                        'utr_number' => $request->utr_number,
                        'remarks' => $request->remarks,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                // Update schedule status to completed
                DB::connection('admin_panel')
                    ->table('disbursement_schedules')
                    ->where('id', $request->disbursement_schedule_id)
                    ->update(['status' => 'completed', 'updated_at' => now()]);

                // Update workflow status if this is the first disbursement
                $this->updateWorkflowStatus($schedule->user_id);

                $logData = [
                    'disbursement_id' => $disbursementId,
                    'user_id' => (int) $schedule->user_id,
                    'disbursement_schedule_id' => (int) $request->disbursement_schedule_id,
                    'disbursement_date' => $request->disbursement_date,
                    'amount' => (float) $request->amount,
                    'jito_jeap_bank_id' => (int) $request->jito_jeap_bank_id,
                    'utr_number' => $request->utr_number,
                    'remarks' => $request->remarks,
                ];
            });

            if ($logData) {
                $actor = Auth::user();

                $this->logUserActivity(
                    processType: 'disbursement',
                    processAction: 'created',
                    processDescription: 'Disbursement of amount ' . $logData['amount'] . ' recorded successfully',
                    module: 'disbursement',
                    oldValues: null,
                    newValues: null,
                    additionalData: $logData,
                    targetUserId: $logData['user_id'],
                    actorId: (int) ($actor?->id ?? 0),
                    actorName: $actor?->name ?? 'System',
                    actorRole: $actor?->role ?? 'system'
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Disbursement recorded successfully! Status updated.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Show disbursement details for a specific user with disbursement modal
     */
    public function show($userId)
    {
        // Get user details
        $user = User::find($userId);

        if (!$user) {
            abort(404, 'Student not found');
        }

        // Get all schedules for this user with disbursement and bank details
        $allSchedules = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->leftJoin('disbursements', 'disbursement_schedules.id', '=', 'disbursements.disbursement_schedule_id')
            ->leftJoin('jito_jeap_banks', 'disbursements.jito_jeap_bank_id', '=', 'jito_jeap_banks.id')
            ->select(
                'disbursement_schedules.*',
                'disbursements.id as disbursement_id',
                'disbursements.disbursement_date',
                'disbursements.amount as disbursed_amount',
                'disbursements.utr_number',
                'disbursements.remarks',
                'jito_jeap_banks.account_name',
                'jito_jeap_banks.bank_name',
                'jito_jeap_banks.account_number'
            )
            ->where('disbursement_schedules.user_id', $userId)
            ->orderBy('disbursement_schedules.installment_no')
            ->get();

        // Get all disbursements for this user
        $allDisbursements = DB::connection('admin_panel')
            ->table('disbursements')
            ->where('user_id', $userId)
            ->orderBy('disbursement_date')
            ->get();

        // Get PDC details for this user
        $pdcDetails = PdcDetail::where('user_id', $userId)->get();

        // Get bank accounts for dropdown
        $bankAccounts = JitoJeapBank::all();

        return view('admin.disbursement.show', compact(
            'user',
            'allSchedules',
            'allDisbursements',
            'pdcDetails',
            'bankAccounts'
        ));
    }

    /**
     * Update workflow status based on disbursement progress
     */
    private function updateWorkflowStatus($userId)
    {
        // Check if this is the first disbursement
        $hasExistingDisbursement = DB::connection('admin_panel')
            ->table('disbursements')
            ->whereIn('disbursement_schedule_id', function ($query) use ($userId) {
                $query->select('id')
                    ->from('disbursement_schedules')
                    ->where('user_id', $userId);
            })
            ->exists();

        if (!$hasExistingDisbursement) {
            // First disbursement - update status to DISBURSEMENT_IN_PROGRESS
            DB::table('application_workflow_statuses')
                ->where('user_id', $userId)
                ->update(['final_status' => 'disbursement_in_progress', 'updated_at' => now()]);
        }

        // Check if all disbursements are completed
        $totalSchedules = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $userId)
            ->count();

        $completedSchedules = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        if ($totalSchedules === $completedSchedules) {
            // All disbursements completed
            DB::table('application_workflow_statuses')
                ->where('user_id', $userId)
                ->update(['final_status' => 'disbursement_completed', 'updated_at' => now()]);
        }
    }

    /**
     * Get students with completed disbursements
     */
    public function completed(Request $request)
    {
        $this->ensureDisbursementSchedulesExist();

        $students = $this->getStudentsWithStatus('completed');

        $totalDisbursementAmount = $students->sum('total_planned_amount');
        $disbursedAmount = $students->sum('total_disbursed_amount');
        $remainingDisbursementAmount = $totalDisbursementAmount - $disbursedAmount;

        $pendingCount = 0;
        $inProgressCount = 0;
        $completedCount = $students->count();

        return view('admin.disbursement.index', compact(
            'students',
            'totalDisbursementAmount',
            'disbursedAmount',
            'remainingDisbursementAmount',
            'pendingCount',
            'inProgressCount',
            'completedCount'
        ))->with('filter', 'completed');
    }

    /**
     * Get students with disbursements in progress
     */
    public function inProgress(Request $request)
    {
        $this->ensureDisbursementSchedulesExist();

        $students = $this->getStudentsWithStatus('in_progress');

        $totalDisbursementAmount = $students->sum('total_planned_amount');
        $disbursedAmount = $students->sum('total_disbursed_amount');
        $remainingDisbursementAmount = $totalDisbursementAmount - $disbursedAmount;

        $pendingCount = 0;
        $inProgressCount = $students->count();
        $completedCount = 0;

        return view('admin.disbursement.index', compact(
            'students',
            'totalDisbursementAmount',
            'disbursedAmount',
            'remainingDisbursementAmount',
            'pendingCount',
            'inProgressCount',
            'completedCount'
        ))->with('filter', 'in_progress');
    }

    /**
     * Get students pending disbursement
     */
    public function pending(Request $request)
    {
        $this->ensureDisbursementSchedulesExist();

        $students = $this->getStudentsWithStatus('pending');

        $totalDisbursementAmount = $students->sum('total_planned_amount');
        $disbursedAmount = $students->sum('total_disbursed_amount');
        $remainingDisbursementAmount = $totalDisbursementAmount - $disbursedAmount;

        $pendingCount = $students->count();
        $inProgressCount = 0;
        $completedCount = 0;

        return view('admin.disbursement.index', compact(
            'students',
            'totalDisbursementAmount',
            'disbursedAmount',
            'remainingDisbursementAmount',
            'pendingCount',
            'inProgressCount',
            'completedCount'
        ))->with('filter', 'pending');
    }

    /**
     * Helper method to get students with specific status
     */
    private function getStudentsWithStatus($status)
    {
        // Get aggregated student data with disbursement summaries
        $scheduleData = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_installments'),
                DB::raw('SUM(planned_amount) as total_planned_amount')
            )
            ->groupBy('user_id')
            ->get();

        // Get disbursed amounts from admin_panel
        $disbursedData = DB::connection('admin_panel')
            ->table('disbursements')
            ->select('user_id', DB::raw('SUM(amount) as total_disbursed_amount'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Get status data from admin_panel
        $statusData = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count')
            )
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Get disbursement counts per user
        $disbursementCounts = DB::connection('admin_panel')
            ->table('disbursements')
            ->select('user_id', DB::raw('COUNT(*) as disbursement_count'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Get user names from default database
        $userIds = $scheduleData->pluck('user_id')->unique()->toArray();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        // Build student list with status
        $allStudents = $scheduleData->map(function ($item) use ($disbursedData, $statusData, $disbursementCounts, $users) {
            $user = $users->get($item->user_id);
            $disbursed = $disbursedData->get($item->user_id);
            $statusInfo = $statusData->get($item->user_id);
            $disbursementCount = $disbursementCounts->get($item->user_id)->disbursement_count ?? 0;

            $totalDisbursedAmount = $disbursed->total_disbursed_amount ?? 0;
            $remainingAmount = $item->total_planned_amount - $totalDisbursedAmount;

            $totalCount = $statusInfo->total_count ?? 0;
            $completedCount = $statusInfo->completed_count ?? 0;
            $amountFullyDisbursed = ($totalDisbursedAmount >= $item->total_planned_amount);

            // Determine status
            $studentStatus = 'pending';
            if ($totalCount > 0 && $disbursementCount === $totalCount && $amountFullyDisbursed) {
                $studentStatus = 'completed';
            } elseif ($disbursementCount > 0 || $totalDisbursedAmount > 0) {
                $studentStatus = 'in_progress';
            }

            return (object) [
                'user_id' => $item->user_id,
                'name' => $user ? $user->name : 'Unknown',
                'total_installments' => $item->total_installments,
                'total_planned_amount' => $item->total_planned_amount,
                'total_disbursed_amount' => $totalDisbursedAmount,
                'remaining_amount' => $remainingAmount,
                'status' => $studentStatus,
            ];
        });

        // Filter by requested status
        return $allStudents->where('status', $status)->sortBy('name')->values();
    }
}
