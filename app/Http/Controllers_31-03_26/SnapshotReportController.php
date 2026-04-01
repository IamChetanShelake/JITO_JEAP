<?php

namespace App\Http\Controllers;

use App\Models\ApplicationWorkflowStatus;
use App\Models\Disbursement;
use App\Models\DisbursementSchedule;
use App\Models\DonationCommitment;
use App\Models\Donor;
use App\Models\DonorPaymentDetail;
use App\Models\Repayment;
use App\Models\ThirdStageDocument;
use App\Models\User;
use App\Models\WorkingCommitteeApproval;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SnapshotReportController extends Controller
{
    public function generate(Request $request)
    {
        $startDate = $this->parseDate($request->query('start_date'));
        $endDate = $this->parseDate($request->query('end_date'));
        $asOfDate = $this->parseDate($request->query('as_of_date')) ?? Carbon::now();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        $reportDate = Carbon::now();

        $applicationStats = $this->buildApplicationStats($startDate, $endDate);
        $applicationStats['second_stage_pending'] = $this->secondStageDocsPending($startDate, $endDate);

        $disbursementStats = $this->buildDisbursementStats($startDate, $endDate, $monthStart, $monthEnd, $asOfDate);
        $donationStats = $this->buildDonationStats($startDate, $endDate);
        $donationCategories = $this->buildDonationCategories();
        $studentContribution = $this->buildStudentContribution($startDate, $endDate, $asOfDate, $monthStart, $monthEnd);
        $memberContributions = $this->buildMemberContributionSummary();
        $workingCommitteeCounts = $this->buildWorkingCommitteeCounts();
        $apexStage2Counts = $this->buildApexStage2Counts();
        $disbursementApplicationCounts = $this->buildDisbursementApplicationCounts();

        $viewData = [
            'periodLabel' => $this->formatPeriodLabel($startDate, $endDate),
            'asOfLabel' => $asOfDate->format('d M Y'),
            'generatedOn' => $reportDate,
            'monthLabel' => $monthStart->format('F Y'),
            'applicationStats' => $applicationStats,
            'disbursementStats' => $disbursementStats,
            'donationStats' => $donationStats,
            'donationCategories' => $donationCategories,
            'memberContributions' => $memberContributions,
            'studentContribution' => $studentContribution,
            'workingCommitteeCounts' => $workingCommitteeCounts,
            'apexStage2Counts' => $apexStage2Counts,
            'disbursementApplicationCounts' => $disbursementApplicationCounts,
        ];

        $pdf = Pdf::loadView('reports.snapshot', $viewData);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('jeap_snapshot_' . $reportDate->format('Ymd_His') . '.pdf');
}

    private function buildMemberContributionSummary(): array
    {
        $categories = [
            ['label' => '3 Lakhs Amount Paid Members', 'min' => 300000],
            ['label' => '3 Lakhs + 17 Lakhs Amount Paid Members', 'min' => 2000000],
            ['label' => '3 Lakhs + 17 Lakhs +17 Lakhs Amount Paid Members', 'min' => 3700000],
            ['label' => '54 Lakhs Amount Paid Members', 'min' => 5400000],
        ];

        $donorTotals = [];
        $donorTypes = [];

        foreach (DonorPaymentDetail::with('donor')->whereNotNull('payment_entries')->cursor() as $detail) {
            $entries = $detail->payment_entries;
            if (is_string($entries)) {
                $entries = json_decode($entries, true);
            }

            if (!is_array($entries)) {
                continue;
            }

            $sum = 0;
            foreach ($entries as $entry) {
                $amount = (float) ($entry['amount'] ?? 0);
                if ($amount <= 0) {
                    continue;
                }
                $sum += $amount;
            }

            if ($sum <= 0) {
                continue;
            }

            $donor = $detail->donor;
            if (!$donor) {
                continue;
            }

            $donorTotals[$donor->id] = ($donorTotals[$donor->id] ?? 0) + $sum;
            $donorTypes[$donor->id] = $donor->donor_type;
        }

        $rows = [];
        $matchedMembers = [];

        foreach ($categories as $category) {
            $count = 0;

            foreach ($donorTotals as $donorId => $total) {
                if (($donorTypes[$donorId] ?? '') !== 'member') {
                    continue;
                }

                if ($total >= $category['min']) {
                    $count++;
                }
            }

            $rows[] = [
                'label' => $category['label'],
                'count' => $count,
                'amount' => $count * $category['min'],
            ];
        }

        $generalAmount = 0;
        foreach ($donorTotals as $donorId => $total) {
            if (($donorTypes[$donorId] ?? '') === 'general') {
                $generalAmount += $total;
            }
        }

        $totalPaidDonors = count($donorTotals);
        $totalPaidAmount = array_sum($donorTotals);
        $totalDonors = Donor::count();
        $totalUnpaid = max(0, $totalDonors - $totalPaidDonors);

        return [
            'rows' => $rows,
            'general_amount' => $generalAmount,
            'total_paid_donors' => $totalPaidDonors,
            'total_paid_amount' => $totalPaidAmount,
            'total_unpaid_donors' => $totalUnpaid,
            'total_donors' => $totalDonors,
        ];
    }

    private function buildApplicationStats(?Carbon $startDate, ?Carbon $endDate): array
    {
        $completeStatuses = ['approved', 'disbursement_in_progress', 'disbursement_completed', 'loan_closed'];

        $total = $this->buildUserQuery($startDate, $endDate)->count();
        $complete = $this->buildUserQuery($startDate, $endDate)
            ->whereHas('workflowStatus', fn(Builder $q) => $q->whereIn('final_status', $completeStatuses))
            ->count();

        $chapterApproved = $this->buildWorkflowQuery($startDate, $endDate)
            ->where('chapter_status', 'approved')
            ->distinct('user_id')
            ->count('user_id');

        $apexApproved = $this->buildWorkflowQuery($startDate, $endDate)
            ->where('apex_2_status', 'approved')
            ->distinct('user_id')
            ->count('user_id');

        $rejected = $this->buildWorkflowQuery($startDate, $endDate)
            ->where('final_status', 'rejected')
            ->distinct('user_id')
            ->count('user_id');

        $onHold = $this->buildWorkflowQuery($startDate, $endDate)
            ->where('final_status', 'hold')
            ->distinct('user_id')
            ->count('user_id');

        $underScrutiny = $this->buildWorkflowQuery($startDate, $endDate)
            ->where('final_status', 'in_progress')
            ->distinct('user_id')
            ->count('user_id');

        $sentBackForCorrection = $this->buildWorkflowQuery($startDate, $endDate)
            ->where('final_status', 'in_progress')
            ->where(function (Builder $query) {
                $query->where('apex_1_status', 'rejected')
                    ->orWhere('chapter_status', 'rejected')
                    ->orWhere('working_committee_status', 'rejected')
                    ->orWhere('apex_2_status', 'rejected');
            })
            ->distinct('user_id')
            ->count('user_id');

        return [
            'total' => $total,
            'complete' => $complete,
            'incomplete' => max(0, $total - $complete),
            'chapter_approved' => $chapterApproved,
            'apex_approved' => $apexApproved,
            'rejected' => $rejected,
            'on_hold' => $onHold,
            'under_scrutiny' => $underScrutiny,
            'sent_back_for_correction' => $sentBackForCorrection,
        ];
    }

    private function secondStageDocsPending(?Carbon $startDate, ?Carbon $endDate): int
    {
        return ThirdStageDocument::query()
            ->whereIn('status', ['pending', 'rejected'])
            ->whereHas('user', fn(Builder $q) => $this->applyUserFilters($q, $startDate, $endDate))
            ->count();
    }

    private function buildDisbursementStats(?Carbon $startDate, ?Carbon $endDate, Carbon $monthStart, Carbon $monthEnd, Carbon $asOfDate): array
    {
        $sanctionedQuery = WorkingCommitteeApproval::query()
            ->where('approval_status', 'approved');

        $totalSanctioned = (clone $sanctionedQuery)
            ->sum('approval_financial_assistance_amount');

        $sanctionedTillDate = (clone $sanctionedQuery)
            ->whereNotNull('w_c_approval_date')
            ->whereDate('w_c_approval_date', '<=', $asOfDate)
            ->sum('approval_financial_assistance_amount');

        $sanctionedThisMonth = (clone $sanctionedQuery)
            ->whereNotNull('w_c_approval_date')
            ->whereBetween('w_c_approval_date', [$monthStart, $monthEnd])
            ->sum('approval_financial_assistance_amount');

        $disbursementBase = Disbursement::query();

        $totalDisbursed = (clone $disbursementBase)->sum('amount');

        $disbursedTillDate = (clone $disbursementBase)
            ->whereNotNull('disbursement_date')
            ->whereDate('disbursement_date', '<=', $asOfDate)
            ->sum('amount');

        $disbursedThisMonth = (clone $disbursementBase)
            ->whereNotNull('disbursement_date')
            ->whereBetween('disbursement_date', [$monthStart, $monthEnd])
            ->sum('amount');

        $readyForDisbursement = DisbursementSchedule::query()
            ->where('status', 'pending')
            ->whereHas('user', fn(Builder $q) => $this->applyUserFilters($q, $startDate, $endDate))
            ->distinct('user_id')
            ->count('user_id');

        $disbursedApplications = (clone $disbursementBase)
            ->distinct('user_id')
            ->count('user_id');

        return [
            'sanctioned' => [
                'total' => $totalSanctioned,
                'till_date' => $sanctionedTillDate,
                'current_month' => $sanctionedThisMonth,
            ],
            'disbursed' => [
                'total' => $totalDisbursed,
                'till_date' => $disbursedTillDate,
                'current_month' => $disbursedThisMonth,
            ],
            'ready_for_disbursement' => $readyForDisbursement,
            'disbursed_applications' => $disbursedApplications,
        ];
    }

    private function buildDonationStats(?Carbon $startDate, ?Carbon $endDate): array
    {
        $totalDonors = Donor::count();
        $totalAmount = 0;
        $periodAmount = 0;
        $paidDonorIds = collect();

        foreach (DonorPaymentDetail::whereNotNull('payment_entries')->cursor() as $detail) {
            $entries = $detail->payment_entries;
            if (is_string($entries)) {
                $entries = json_decode($entries, true);
            }
            if (!is_array($entries)) {
                continue;
            }

            foreach ($entries as $entry) {
                $amount = (float) ($entry['amount'] ?? 0);
                if ($amount <= 0) {
                    continue;
                }

                $totalAmount += $amount;
                $periodMatch = $this->isWithinRange(
                    $this->parseDate($entry['cheque_date'] ?? $entry['payment_date'] ?? null),
                    $startDate,
                    $endDate
                );

                if ($periodMatch) {
                    $periodAmount += $amount;
                }

                $paidDonorIds->push($detail->donor_id);
            }
        }

        $paidDonors = $paidDonorIds->unique()->count();

        return [
            'total_donors' => $totalDonors,
            'paid_donors' => $paidDonors,
            'unpaid_donors' => max(0, $totalDonors - $paidDonors),
            'total_donation_amount' => $totalAmount,
            'period_donation_amount' => $periodAmount,
        ];
    }

    private function buildDonationCategories(): array
    {
        return DonationCommitment::query()
            ->select('committed_amount')
            ->selectRaw('COUNT(*) as donor_count')
            ->selectRaw('SUM(committed_amount) as total_amount')
            ->groupBy('committed_amount')
            ->orderByDesc('committed_amount')
            ->get()
            ->map(function ($row) {
                return [
                    'label' => $this->formatDonationCategoryLabel($row->committed_amount),
                    'count' => $row->donor_count,
                    'amount' => (float) $row->total_amount,
                ];
            })
            ->values()
            ->toArray();
    }

    private function buildStudentContribution(?Carbon $startDate, ?Carbon $endDate, Carbon $asOfDate, Carbon $monthStart, Carbon $monthEnd): array
    {
        $total = Repayment::sum('amount');
        $tillDate = Repayment::whereDate('payment_date', '<=', $asOfDate)->sum('amount');
        $currentMonth = Repayment::whereBetween('payment_date', [$monthStart, $monthEnd])->sum('amount');

        return [
            'total' => $total,
            'till_date' => $tillDate,
            'current_month' => $currentMonth,
        ];
    }

    private function buildWorkingCommitteeCounts(): array
    {
        $approved = User::where('role', 'user')
            ->whereHas('workflowStatus', function (Builder $q) {
                $q->where('working_committee_status', 'approved');
            })
            ->count();

        $pending = User::where('role', 'user')
            ->whereHas('workflowStatus', function (Builder $q) {
                $q->where('current_stage', 'working_committee')
                    ->where('final_status', 'in_progress');
            })
            ->count();

        $hold = User::where('role', 'user')
            ->whereHas('workflowStatus', function (Builder $q) {
                $q->where('working_committee_status', 'hold');
            })
            ->count();

        $rejected = User::where('role', 'user')
            ->whereHas('workflowStatus', function (Builder $q) {
                $q->where('working_committee_status', 'rejected');
            })
            ->count();

        return [
            'approved' => $approved,
            'pending' => $pending,
            'hold' => $hold,
            'rejected' => $rejected,
        ];
    }

    private function buildApexStage2Counts(): array
    {
        $approved = User::where('role', 'user')
            ->whereHas('workflowStatus', function (Builder $q) {
                $q->where('apex_2_status', 'approved');
            })
            ->count();

        $pending = User::where('role', 'user')
            ->whereHas('workflowStatus', function (Builder $q) {
                $q->where('apex_2_status', 'pending');
            })
            ->count();

        $sendBack = User::where('role', 'user')
            ->whereHas('workflowStatus', function (Builder $q) {
                $q->where('apex_2_status', 'rejected');
            })
            ->count();

        $resubmitted = User::where('role', 'user')
            ->whereHas('workflowStatus', function (Builder $q) {
                $q->where('apex_2_status', 'pending')
                    ->whereNotNull('apex_2_reject_remarks');
            })
            ->count();

        return [
            'approved' => $approved,
            'pending' => $pending,
            'send_back' => $sendBack,
            'resubmitted' => $resubmitted,
        ];
    }

    private function buildDisbursementApplicationCounts(): array
    {
        $counts = $this->fetchDisbursementCounts();

        return [
            'ready' => $counts['pending'],
            'completed' => $counts['completed'],
        ];
    }

    private function fetchDisbursementCounts(): array
    {
        try {
            $scheduleData = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->select(
                    'user_id',
                    DB::raw('COUNT(*) as total_count'),
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

            $disbursementCounts = DB::connection('admin_panel')
                ->table('disbursements')
                ->select('user_id', DB::raw('COUNT(*) as disbursement_count'))
                ->groupBy('user_id')
                ->get()
                ->keyBy('user_id');

            $completed = 0;
            $inProgress = 0;
            $pending = 0;

            foreach ($scheduleData as $item) {
                $disbursed = $disbursedData->get($item->user_id);
                $statusInfo = $statusData->get($item->user_id);
                $disbursementCount = $disbursementCounts->get($item->user_id)->disbursement_count ?? 0;

                $totalDisbursedAmount = $disbursed->total_disbursed_amount ?? 0;
                $totalCount = $statusInfo->total_count ?? 0;
                $amountFullyDisbursed = ($totalDisbursedAmount >= $item->total_planned_amount);

                if ($totalCount > 0 && $disbursementCount === $totalCount && $amountFullyDisbursed) {
                    $completed++;
                } elseif ($disbursementCount > 0 || $totalDisbursedAmount > 0) {
                    $inProgress++;
                } else {
                    $pending++;
                }
            }

            return [
                'completed' => $completed,
                'in_progress' => $inProgress,
                'pending' => $pending,
                'total' => $completed + $inProgress + $pending
            ];
        } catch (\Exception $e) {
            return [
                'completed' => 0,
                'in_progress' => 0,
                'pending' => 0,
                'total' => 0
            ];
        }
    }

    private function buildUserQuery(?Carbon $startDate, ?Carbon $endDate): Builder
    {
        $query = User::where('role', 'user');
        $this->applyDateRange($query, 'created_at', $startDate, $endDate);
        return $query;
    }

    private function buildWorkflowQuery(?Carbon $startDate, ?Carbon $endDate): Builder
    {
        $query = ApplicationWorkflowStatus::query();
        $this->applyUserFilters($query, $startDate, $endDate);
        return $query;
    }

    private function applyUserFilters(Builder $query, ?Carbon $startDate, ?Carbon $endDate): void
    {
        $model = $query->getModel();

        if ($model instanceof User) {
            $query->where('role', 'user');
            $this->applyDateRange($query, 'created_at', $startDate, $endDate);
            return;
        }

        $query->whereHas('user', function (Builder $userQuery) use ($startDate, $endDate) {
            $this->applyUserFilters($userQuery, $startDate, $endDate);
        });
    }

    private function applyDateRange(Builder $query, string $column, ?Carbon $startDate, ?Carbon $endDate): void
    {
        if ($startDate) {
            $query->where($column, '>=', $startDate->copy()->startOfDay());
        }

        if ($endDate) {
            $query->where($column, '<=', $endDate->copy()->endOfDay());
        }
    }

    private function parseDate(?string $value): ?Carbon
    {
        if (!$value) {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function isWithinRange(?Carbon $date, ?Carbon $startDate, ?Carbon $endDate): bool
    {
        if (!$date) {
            return $startDate === null && $endDate === null;
        }

        if ($startDate && $date->lt($startDate->copy()->startOfDay())) {
            return false;
        }

        if ($endDate && $date->gt($endDate->copy()->endOfDay())) {
            return false;
        }

        return true;
    }

    private function formatPeriodLabel(?Carbon $startDate, ?Carbon $endDate): string
    {
        if ($startDate && $endDate) {
            return $startDate->format('d M Y') . ' – ' . $endDate->format('d M Y');
        }

        if ($startDate) {
            return $startDate->format('d M Y') . ' onwards';
        }

        if ($endDate) {
            return 'Until ' . $endDate->format('d M Y');
        }

        return 'Since inception';
    }

    private function formatDonationCategoryLabel(float $amount): string
    {
        if ($amount >= 100000) {
            $lakhs = round($amount / 100000, 2);
            $lakhs = rtrim(rtrim(number_format($lakhs, 2, '.', ''), '0'), '.');
            return $lakhs . 'L';
        }

        return '₹' . number_format($amount, 0, '.', ',');
    }
}
