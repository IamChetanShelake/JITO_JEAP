<?php

namespace App\Http\Controllers;

use App\Traits\LogsUserActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RepaymentController extends Controller
{
    use LogsUserActivity;

    public function index()
    {
        $students = $this->getStudentsByRepaymentStatus();
        $counts = $this->getRepaymentCounts();

        return view('admin.repayments.index', [
            'students' => $students,
            'completedCount' => $counts['completed'],
            'inProgressCount' => $counts['in_progress'],
            'readyCount' => $counts['ready'],
        ]);
    }

    public function completed()
    {
        $students = $this->getStudentsByRepaymentStatus('completed');
        $counts = $this->getRepaymentCounts();

        return view('admin.repayments.index', [
            'students' => $students,
            'completedCount' => $counts['completed'],
            'inProgressCount' => $counts['in_progress'],
            'readyCount' => $counts['ready'],
            'filter' => 'completed',
        ]);
    }

    public function inProgress()
    {
        $students = $this->getStudentsByRepaymentStatus('in_progress');
        $counts = $this->getRepaymentCounts();

        return view('admin.repayments.index', [
            'students' => $students,
            'completedCount' => $counts['completed'],
            'inProgressCount' => $counts['in_progress'],
            'readyCount' => $counts['ready'],
            'filter' => 'in_progress',
        ]);
    }

    public function ready()
    {
        $students = $this->getStudentsByRepaymentStatus('ready');
        $counts = $this->getRepaymentCounts();

        return view('admin.repayments.index', [
            'students' => $students,
            'completedCount' => $counts['completed'],
            'inProgressCount' => $counts['in_progress'],
            'readyCount' => $counts['ready'],
            'filter' => 'ready',
        ]);
    }

    public function show($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            abort(404, 'Student not found');
        }

        $totalLoanAmount = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $userId)
            ->sum('planned_amount');

        $totalDisbursedAmount = DB::connection('admin_panel')
            ->table('disbursements')
            ->where('user_id', $userId)
            ->sum('amount');

        $totalRepaidAmount = DB::connection('admin_panel')
            ->table('repayments')
            ->where('user_id', $userId)
            ->where('status', '!=', 'bounced')
            ->sum('amount');

        $outstandingAmount = max($totalDisbursedAmount - $totalRepaidAmount, 0);

        $repayments = DB::connection('admin_panel')
            ->table('repayments')
            ->where('user_id', $userId)
            ->orderBy('payment_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.repayments.show', compact(
            'user',
            'totalLoanAmount',
            'totalDisbursedAmount',
            'totalRepaidAmount',
            'outstandingAmount',
            'repayments'
        ));
    }

    public function store(Request $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            abort(404, 'Student not found');
        }

        $totalDisbursedAmount = DB::connection('admin_panel')
            ->table('disbursements')
            ->where('user_id', $userId)
            ->sum('amount');

        $totalRepaidAmount = DB::connection('admin_panel')
            ->table('repayments')
            ->where('user_id', $userId)
            ->where('status', '!=', 'bounced')
            ->sum('amount');

        $outstandingAmount = max($totalDisbursedAmount - $totalRepaidAmount, 0);

        $validator = Validator::make($request->all(), [
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_mode' => 'required|in:pdc,neft,cash',
            'reference_number' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $validator->after(function ($validator) use ($request, $outstandingAmount) {
            if ($outstandingAmount <= 0) {
                $validator->errors()->add('amount', 'Outstanding amount is 0. No repayment can be added.');
                return;
            }

            if ($request->amount > $outstandingAmount) {
                $validator->errors()->add('amount', 'Amount cannot exceed outstanding amount.');
            }

            $mode = $request->payment_mode;
            $reference = trim((string) $request->reference_number);
            if (in_array($mode, ['pdc', 'neft'], true) && $reference === '') {
                $validator->errors()->add('reference_number', 'Reference number is required for PDC and NEFT payments.');
            }
        });

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $status = $request->payment_mode === 'pdc' ? 'pending' : 'cleared';

        $repaymentId = null;
        $updatedRepaidAmount = 0;
        $updatedOutstandingAmount = $outstandingAmount;
        $loanClosed = false;

        DB::connection('admin_panel')->transaction(function () use ($request, $userId, $status, &$repaymentId, &$updatedRepaidAmount, &$updatedOutstandingAmount, &$loanClosed) {
            $repaymentId = DB::connection('admin_panel')
                ->table('repayments')
                ->insertGetId([
                    'user_id' => $userId,
                    'payment_date' => $request->payment_date,
                    'amount' => $request->amount,
                    'payment_mode' => $request->payment_mode,
                    'reference_number' => $request->reference_number,
                    'status' => $status,
                    'remarks' => $request->remarks,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            $updatedRepaidAmount = DB::connection('admin_panel')
                ->table('repayments')
                ->where('user_id', $userId)
                ->where('status', '!=', 'bounced')
                ->sum('amount');

            $totalDisbursedAmount = DB::connection('admin_panel')
                ->table('disbursements')
                ->where('user_id', $userId)
                ->sum('amount');

            $updatedOutstandingAmount = max($totalDisbursedAmount - $updatedRepaidAmount, 0);

            if ($updatedOutstandingAmount == 0) {
                DB::table('application_workflow_statuses')
                    ->where('user_id', $userId)
                    ->update(['final_status' => 'loan_closed', 'updated_at' => now()]);

                $loanClosed = true;
            }
        });

        $actor = Auth::user();
        $this->logUserActivity(
            processType: 'repayment',
            processAction: 'created',
            processDescription: 'Repayment of amount ' . $request->amount . ' recorded successfully',
            module: 'repayment',
            oldValues: null,
            newValues: null,
            additionalData: [
                'repayment_id' => $repaymentId,
                'payment_date' => $request->payment_date,
                'amount' => (float) $request->amount,
                'payment_mode' => $request->payment_mode,
                'reference_number' => $request->reference_number,
                'status' => $status,
                'remarks' => $request->remarks,
                'total_repaid_amount' => $updatedRepaidAmount,
                'outstanding_amount' => $updatedOutstandingAmount,
                'loan_closed' => $loanClosed,
            ],
            targetUserId: $user->id,
            actorId: (int) ($actor?->id ?? 0),
            actorName: $actor?->name ?? 'System',
            actorRole: $actor?->role ?? 'system'
        );

        return redirect()
            ->route('admin.repayments.show', ['user' => $userId])
            ->with('success', 'Repayment recorded successfully.');
    }

    private function getRepaymentCounts()
    {
        $scheduleData = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->select(
                'user_id',
                DB::raw('SUM(planned_amount) as total_planned_amount')
            )
            ->groupBy('user_id')
            ->get();

        $disbursedData = DB::connection('admin_panel')
            ->table('disbursements')
            ->select('user_id', DB::raw('SUM(amount) as total_disbursed_amount'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $repaymentData = DB::connection('admin_panel')
            ->table('repayments')
            ->select('user_id', DB::raw('SUM(amount) as total_repaid_amount'))
            ->where('status', '!=', 'bounced')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $completed = 0;
        $inProgress = 0;
        $ready = 0;

        foreach ($scheduleData as $item) {
            $disbursed = $disbursedData->get($item->user_id);
            $totalDisbursedAmount = $disbursed->total_disbursed_amount ?? 0;

            if ($totalDisbursedAmount <= 0) {
                continue;
            }

            $repaid = $repaymentData->get($item->user_id);
            $totalRepaidAmount = $repaid->total_repaid_amount ?? 0;
            $outstandingAmount = max($totalDisbursedAmount - $totalRepaidAmount, 0);

            if ($outstandingAmount == 0) {
                $completed++;
            } elseif ($totalRepaidAmount > 0) {
                $inProgress++;
            } else {
                $ready++;
            }
        }

        return [
            'completed' => $completed,
            'in_progress' => $inProgress,
            'ready' => $ready,
        ];
    }

    private function getStudentsByRepaymentStatus($status = null)
    {
        $scheduleData = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->select(
                'user_id',
                DB::raw('SUM(planned_amount) as total_planned_amount')
            )
            ->groupBy('user_id')
            ->get();

        $disbursedData = DB::connection('admin_panel')
            ->table('disbursements')
            ->select('user_id', DB::raw('SUM(amount) as total_disbursed_amount'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $repaymentData = DB::connection('admin_panel')
            ->table('repayments')
            ->select('user_id', DB::raw('SUM(amount) as total_repaid_amount'))
            ->where('status', '!=', 'bounced')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $userIds = $scheduleData->pluck('user_id')->unique()->toArray();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        $students = $scheduleData->map(function ($item) use ($disbursedData, $repaymentData, $users) {
            $user = $users->get($item->user_id);
            $disbursed = $disbursedData->get($item->user_id);
            $repaid = $repaymentData->get($item->user_id);

            $totalDisbursedAmount = $disbursed->total_disbursed_amount ?? 0;
            $totalRepaidAmount = $repaid->total_repaid_amount ?? 0;
            $outstandingAmount = max($totalDisbursedAmount - $totalRepaidAmount, 0);

            if ($totalDisbursedAmount <= 0) {
                $repaymentStatus = 'not_ready';
            } elseif ($outstandingAmount == 0) {
                $repaymentStatus = 'completed';
            } elseif ($totalRepaidAmount > 0) {
                $repaymentStatus = 'in_progress';
            } else {
                $repaymentStatus = 'ready';
            }

            return (object) [
                'user_id' => $item->user_id,
                'name' => $user ? $user->name : 'Unknown',
                'total_planned_amount' => $item->total_planned_amount,
                'total_disbursed_amount' => $totalDisbursedAmount,
                'total_repaid_amount' => $totalRepaidAmount,
                'outstanding_amount' => $outstandingAmount,
                'status' => $repaymentStatus,
            ];
        })->filter(function ($student) use ($status) {
            if ($status === null) {
                return $student->status !== 'not_ready';
            }

            return $student->status === $status;
        })->sortBy('name')->values();

        return $students;
    }
}
