<?php

namespace App\Http\Controllers;

use App\Exports\GroupedApplicationsExport;
use App\Exports\DynamicReportExport;
use App\Models\Repayment;
use App\Models\SavedView;
use App\Models\User;
use App\Services\DynamicViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationViewController extends Controller
{
    public function view(Request $request, DynamicViewService $service)
    {
        $defaultColumns = [
            'application_no',
            'name',
            'middle_name',
            'aadhar',
            'chapter',
            'state',
            'zone',
            'request_date',
            'status',
            'approved_amount',
            'paid_amount',
            'created_at',
        ];
        $records = $this->fetchRecords($defaultColumns);

        return view('admin.applications.dynamic_view', [
            'records' => $records,
            'availableColumns' => $this->availableColumns(),
            'availableGroupFields' => $this->availableGroupFields(),
            'defaultColumns' => $defaultColumns,
        ]);
    }

    public function group(Request $request, DynamicViewService $service)
    {
        $columns = $request->input('columns', []);
        $groupBy = $request->input('group_by', []);
        $filters = $request->input('filters', []);

        if (empty($columns)) {
            $columns = array_keys($this->availableColumns());
        }

        $records = $this->fetchRecords($columns, $groupBy);
        $records = $service->applyFilters($records, is_array($filters) ? $filters : []);

        $grouped = $service->groupRecords($records, $groupBy);

        return response()->json([
            'columns' => $columns,
            'group_by' => $groupBy,
            'data' => $grouped,
        ]);
    }

    public function saveView(Request $request)
    {
        try {
            $request->validate([
                'view_name' => 'required|string|max:255',
                'columns_json' => 'nullable|array',
                'group_by_json' => 'nullable|array',
                'filters_json' => 'nullable',
            ]);

            $userId = Auth::guard('admin')->id() ?? Auth::id();
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized.',
                ], 401);
            }

            $view = SavedView::create([
                'user_id' => $userId,
                'view_name' => $request->input('view_name'),
                'columns_json' => $request->input('columns_json', []),
                'group_by_json' => $request->input('group_by_json', []),
                'filters_json' => $request->input('filters_json', []),
            ]);

            return response()->json([
                'success' => true,
                'view' => $view,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save view.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getView(int $id)
    {
        $view = SavedView::findOrFail($id);

        return response()->json([
            'success' => true,
            'view' => $view,
        ]);
    }

    public function listViews()
    {
        $userId = Auth::guard('admin')->id() ?? Auth::id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        $views = SavedView::where('user_id', $userId)
            ->orderByDesc('id')
            ->get(['id', 'view_name', 'columns_json', 'group_by_json', 'filters_json']);

        return response()->json([
            'success' => true,
            'views' => $views,
        ]);
    }

    public function export(Request $request, DynamicViewService $service)
    {
        $columns = $request->input('columns', []);
        $groupBy = $request->input('group_by', []);
        $filters = $request->input('filters', []);

        if (empty($columns)) {
            $columns = array_keys($this->availableColumns());
        }

        $records = $this->fetchRecords($columns, $groupBy);
        $records = $service->applyFilters($records, is_array($filters) ? $filters : []);
        $grouped = $service->groupRecords($records, $groupBy);

        $labels = $this->availableColumns();
        $fileName = 'Applications_View_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new GroupedApplicationsExport($grouped, $columns, $labels),
            $fileName
        );
    }

    protected function fetchRecords(array $columns, array $groupBy = []): Collection
    {
        $fields = array_values(array_unique(array_merge($columns, $groupBy)));
        $resolver = new DynamicReportExport($fields, []);
        $relationships = $resolver->requiredRelationships();
        if (in_array('chapter', $fields, true) || in_array('zone', $fields, true)) {
            $relationships[] = 'chapterMaster';
            $relationships[] = 'chapterMaster.zone';
        }
        if (in_array('status', $fields, true)) {
            $relationships[] = 'workflowStatus';
        }
        if (in_array('approved_amount', $fields, true)) {
            $relationships[] = 'workingCommitteeApproval';
        }
        $relationships = array_unique($relationships);

        $users = User::with($relationships)
            ->where('role', 'user')
            ->get();

        $paidMap = $this->getPaidAmounts($users->pluck('id')->all());

        return $users->map(function (User $user) use ($fields, $paidMap, $resolver) {
            $row = ['id' => $user->id];
            foreach ($fields as $column) {
                $row[$column] = $this->resolveColumnValue($user, $column, $paidMap, $resolver);
            }
            return $row;
        });
    }

    protected function resolveColumnValue(User $user, string $column, array $paidMap, DynamicReportExport $resolver)
    {
        $value = match ($column) {
            'application_no' => $user->application_no,
            'name' => $user->name,
            'middle_name' => $user->middle_name,
            'aadhar' => $user->aadhar_card_number
                ?? $user->aadhaar_number
                ?? $user->aadhar
                ?? null,
            'chapter' => $user->chapterMaster?->chapter_name ?? $user->chapter,
            'state' => $user->state,
            'zone' => $user->chapterMaster?->zone?->zone_name ?? $user->zone,
            'request_date' => $user->created_at?->format('Y-m-d'),
            'status' => $user->workflowStatus?->final_status ?? $user->workflowStatus?->current_stage,
            'approved_amount' => $user->workingCommitteeApproval?->approval_financial_assistance_amount,
            'paid_amount' => $paidMap[$user->id] ?? 0,
            'created_at' => $user->created_at?->format('Y-m-d'),
            default => null,
        };
        if ($value !== null) {
            return $value;
        }

        return $resolver->resolveFieldValue($user, $column);
    }

    protected function getPaidAmounts(array $userIds): array
    {
        if (empty($userIds)) {
            return [];
        }

        return Repayment::query()
            ->whereIn('user_id', $userIds)
            ->selectRaw('user_id, SUM(amount) as total_paid')
            ->groupBy('user_id')
            ->pluck('total_paid', 'user_id')
            ->toArray();
    }

    protected function availableColumns(): array
    {
        return [
            'application_no' => 'Application No',
            'name' => 'Name',
            'middle_name' => 'Middle Name',
            'aadhar' => 'Aadhar',
            'chapter' => 'Chapter',
            'state' => 'State',
            'zone' => 'Zone',
            'request_date' => 'Request Date',
            'status' => 'Status',
            'approved_amount' => 'Approved Amount',
            'paid_amount' => 'Paid Amount',
            'created_at' => 'Created At',
        ];
    }

    protected function availableGroupFields(): array
    {
        return $this->availableColumns();
    }
}
