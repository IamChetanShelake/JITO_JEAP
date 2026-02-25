<?php

namespace App\Http\Controllers;

use App\Traits\LogsUserActivity;
use App\Models\PdcDetail;
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

    public function upcoming(Request $request)
    {
        $todayOnly = $request->boolean('today_only');
        $repayments = $this->getRepaymentEntriesByPeriod('upcoming', $request);
        $todayPendingCountRequest = Request::create('', 'GET', [
            'student_type' => $request->get('student_type'),
            'today_only' => 1,
        ]);
        $todayPendingCount = $this->getRepaymentEntriesByPeriod('upcoming', $todayPendingCountRequest)->count();

        return view('admin.repayments.schedule_list', [
            'repayments' => $repayments,
            'period' => 'upcoming',
            'pageTitle' => 'Upcoming Repayment Installments',
            'studentType' => $request->get('student_type'),
            'dateFrom' => $request->get('date_from'),
            'dateTo' => $request->get('date_to'),
            'todayOnly' => $todayOnly,
            'todayPendingCount' => $todayPendingCount,
        ]);
    }

    public function past(Request $request)
    {
        $repayments = $this->getRepaymentEntriesByPeriod('past', $request);

        return view('admin.repayments.schedule_list', [
            'repayments' => $repayments,
            'period' => 'past',
            'pageTitle' => 'Completed Repayment Installments',
            'studentType' => $request->get('student_type'),
            'dateFrom' => $request->get('date_from'),
            'dateTo' => $request->get('date_to'),
        ]);
    }

    /**
     * Export repayment list as Excel-compatible CSV.
     * If filter is selected, export only that filtered list.
     */
    public function export(Request $request)
    {
        $filter = $request->get('filter');
        $allowedFilters = ['completed', 'in_progress', 'ready'];
        $status = in_array($filter, $allowedFilters, true) ? $filter : null;

        $students = $this->getStudentsByRepaymentStatus($status);
        $fileSuffix = $status ? $status : 'all';
        $filename = 'repayments_' . $fileSuffix . '_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($students) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Student ID',
                'Student Name',
                'Total Loan Amount',
                'Total Disbursed',
                'Total Repaid',
                'Outstanding',
                'Status',
            ]);

            foreach ($students as $student) {
                fputcsv($handle, [
                    $student->user_id,
                    $student->name,
                    $student->total_planned_amount,
                    $student->total_disbursed_amount,
                    $student->total_repaid_amount,
                    $student->outstanding_amount,
                    $student->status,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPeriod(Request $request, string $period)
    {
        if (!in_array($period, ['upcoming', 'past'], true)) {
            abort(404);
        }

        $repayments = $this->getRepaymentEntriesByPeriod($period, $request);
        $filename = $period . '_repayment_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($repayments) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Student ID',
                'Student Name',
                'Student Type',
                'Installment',
                'Paid Installments',
                'Pending Installments',
                'Repayment Date',
                'Installment Amount',
                'Cheque Number',
                'Status',
            ]);

            foreach ($repayments as $repayment) {
                fputcsv($handle, [
                    $repayment->user_id,
                    $repayment->student_name,
                    $repayment->student_type,
                    $repayment->installment_no,
                    $repayment->paid_installments ?? 0,
                    $repayment->pending_installments ?? 0,
                    $repayment->repayment_date,
                    $repayment->amount,
                    $repayment->cheque_number ?? '',
                    ucfirst((string) $repayment->status),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
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

        $repaymentInstallments = $this->getRepaymentInstallmentsForUser((int) $userId);
        $remainingPaidAmount = (float) $totalRepaidAmount;
        $repaymentInstallments = $repaymentInstallments->map(function ($installment) use (&$remainingPaidAmount) {
            $installmentAmount = (float) $installment->amount;

            if ($remainingPaidAmount >= $installmentAmount && $installmentAmount > 0) {
                $installment->status = 'paid';
                $remainingPaidAmount -= $installmentAmount;
            } elseif ($remainingPaidAmount > 0 && $installmentAmount > 0) {
                $installment->status = 'partial';
                $remainingPaidAmount = 0;
            } else {
                $installment->status = 'pending';
            }

            return $installment;
        });

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
            'repayments',
            'repaymentInstallments'
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

        $selectedInstallment = null;
        if ($request->filled('installment_no')) {
            $selectedInstallment = $this->getRepaymentInstallmentsForUser((int) $userId)
                ->firstWhere('installment_no', (int) $request->installment_no);
        }

        $validator = Validator::make($request->all(), [
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_mode' => 'required|in:pdc,neft,cash',
            'reference_number' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'installment_no' => 'nullable|integer|min:1',
        ]);

        $validator->after(function ($validator) use ($request, $outstandingAmount, $selectedInstallment) {
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

            if ($request->filled('installment_no') && !$selectedInstallment) {
                $validator->errors()->add('installment_no', 'Selected repayment installment was not found in PDC details.');
            }

            if ($selectedInstallment && $request->amount > (float) $selectedInstallment->amount) {
                $validator->errors()->add('amount', 'Amount cannot exceed selected installment amount.');
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
                'installment_no' => $request->installment_no,
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

    /**
     * Read repayment installments from pdc_details.cheque_details JSON.
     */
    private function getRepaymentInstallmentsForUser(int $userId)
    {
        $pdcDetail = PdcDetail::query()
            ->where('user_id', $userId)
            ->latest('id')
            ->first();

        if (!$pdcDetail) {
            return collect();
        }

        $chequeDetails = $pdcDetail->cheque_details;
        if (is_string($chequeDetails)) {
            $decoded = json_decode($chequeDetails, true);
            $chequeDetails = is_array($decoded) ? $decoded : [];
        }

        if (!is_array($chequeDetails)) {
            return collect();
        }

        return collect($chequeDetails)
            ->filter(fn($item) => is_array($item))
            ->map(function (array $item, int $index) {
                return (object) [
                    'installment_no' => (int) ($item['row_number'] ?? ($index + 1)),
                    'cheque_date' => $item['cheque_date'] ?? null,
                    'amount' => (float) ($item['amount'] ?? 0),
                    'bank_name' => $item['bank_name'] ?? null,
                    'ifsc' => $item['ifsc'] ?? null,
                    'account_number' => $item['account_number'] ?? null,
                    'cheque_number' => $item['cheque_number'] ?? null,
                    'parents_jnt_ac_name' => $item['parents_jnt_ac_name'] ?? null,
                ];
            })
            ->sortBy('installment_no')
            ->values();
    }

    /**
     * Fetch repayment installment list by period from PDC cheque_details.
     * upcoming = pending installments, past = completed installments.
     */
    private function getRepaymentEntriesByPeriod(string $period, Request $request)
    {
        $studentType = $request->get('student_type');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $todayOnly = $request->boolean('today_only');
        $today = now()->toDateString();

        $userQuery = User::query()->select('id', 'name', 'financial_asset_type', 'financial_asset_for');

        if ($studentType === 'domestic_ug') {
            $userQuery->where('financial_asset_type', 'domestic')
                ->where('financial_asset_for', 'graduation');
        } elseif ($studentType === 'domestic_pg') {
            $userQuery->where('financial_asset_type', 'domestic')
                ->where('financial_asset_for', 'post_graduation');
        } elseif ($studentType === 'foreign_pg') {
            $userQuery->where('financial_asset_type', 'foreign_finance_assistant')
                ->where('financial_asset_for', 'post_graduation');
        }

        $users = $userQuery->get()->keyBy('id');
        $userIds = $users->keys()->values()->all();

        if (empty($userIds)) {
            return collect();
        }

        $pdcDetailsByUser = PdcDetail::query()
            ->whereIn('user_id', $userIds)
            ->orderByDesc('id')
            ->get()
            ->groupBy('user_id')
            ->map(fn($items) => $items->first());

        $repaidByUser = DB::connection('admin_panel')
            ->table('repayments')
            ->select('user_id', DB::raw('SUM(amount) as total_repaid_amount'))
            ->whereIn('user_id', $userIds)
            ->where('status', '!=', 'bounced')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $rows = collect();

        foreach ($users as $userId => $user) {
            $pdcDetail = $pdcDetailsByUser->get($userId);
            if (!$pdcDetail) {
                continue;
            }

            $chequeDetails = $pdcDetail->cheque_details;
            if (is_string($chequeDetails)) {
                $decoded = json_decode($chequeDetails, true);
                $chequeDetails = is_array($decoded) ? $decoded : [];
            }

            if (!is_array($chequeDetails) || empty($chequeDetails)) {
                continue;
            }

            $installments = collect($chequeDetails)
                ->filter(fn($item) => is_array($item))
                ->map(function (array $item, int $index) {
                    return (object) [
                        'installment_no' => (int) ($item['row_number'] ?? ($index + 1)),
                        'repayment_date' => $item['cheque_date'] ?? null,
                        'amount' => (float) ($item['amount'] ?? 0),
                        'cheque_number' => $item['cheque_number'] ?? null,
                    ];
                })
                ->sortBy('installment_no')
                ->values();

            if ($installments->isEmpty()) {
                continue;
            }

            $totalInstallments = $installments->count();
            $remainingPaid = (float) ($repaidByUser->get($userId)->total_repaid_amount ?? 0);

            foreach ($installments as $installment) {
                if ($remainingPaid >= $installment->amount && $installment->amount > 0) {
                    $status = 'completed';
                    $remainingPaid -= $installment->amount;
                } else {
                    $status = 'pending';
                }

                if ($period === 'upcoming' && $status !== 'pending') {
                    continue;
                }
                if ($period === 'past' && $status !== 'completed') {
                    continue;
                }

                if ($period === 'upcoming' && $todayOnly) {
                    if (empty($installment->repayment_date) || $installment->repayment_date !== $today) {
                        continue;
                    }
                }

                if (!empty($dateFrom) && !$todayOnly && !empty($installment->repayment_date) && $installment->repayment_date < $dateFrom) {
                    continue;
                }
                if (!empty($dateTo) && !$todayOnly && !empty($installment->repayment_date) && $installment->repayment_date > $dateTo) {
                    continue;
                }

                $paidInstallments = $status === 'completed'
                    ? $installment->installment_no
                    : max($installment->installment_no - 1, 0);

                $rows->push((object) [
                    'user_id' => $userId,
                    'student_name' => $user->name ?? 'Unknown',
                    'student_type' => $this->formatStudentType($user),
                    'installment_no' => $installment->installment_no,
                    'paid_installments' => min($paidInstallments, $totalInstallments),
                    'pending_installments' => max($totalInstallments - $paidInstallments, 0),
                    'repayment_date' => $installment->repayment_date,
                    'amount' => $installment->amount,
                    'cheque_number' => $installment->cheque_number,
                    'status' => $status,
                ]);
            }
        }

        return $rows->sortBy([
            ['repayment_date', $period === 'upcoming' ? 'asc' : 'desc'],
            ['student_name', 'asc'],
            ['installment_no', 'asc'],
        ])->values();
    }

    private function formatStudentType($user): string
    {
        if (!$user) {
            return 'N/A';
        }

        if ($user->financial_asset_type === 'domestic' && $user->financial_asset_for === 'graduation') {
            return 'Domestic - UG';
        }

        if ($user->financial_asset_type === 'domestic' && $user->financial_asset_for === 'post_graduation') {
            return 'Domestic - PG';
        }

        if ($user->financial_asset_type === 'foreign_finance_assistant' && $user->financial_asset_for === 'post_graduation') {
            return 'Foreign - PG';
        }

        return 'N/A';
    }
}
