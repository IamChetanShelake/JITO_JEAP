<?php

namespace App\Services;

use Illuminate\Support\Collection;

class DynamicViewService
{
    /**
     * Apply filters to a collection of flat records.
     *
     * Filters can be:
     * - Associative: ['status' => 'approved']
     * - List: [['field' => 'status', 'operator' => '=', 'value' => 'approved']]
     */
    public function applyFilters(Collection $records, array $filters): Collection
    {
        $normalized = $this->normalizeFilters($filters);
        if (empty($normalized)) {
            return $records;
        }

        return $records->filter(function (array $row) use ($normalized) {
            foreach ($normalized as $filter) {
                $field = $filter['field'];
                $operator = $filter['operator'];
                $value = $filter['value'];

                $rowValue = $row[$field] ?? null;
                if (!$this->passesFilter($rowValue, $operator, $value)) {
                    return false;
                }
            }
            return true;
        })->values();
    }

    /**
     * Group records recursively and calculate aggregations.
     *
     * @return array
     */
    public function groupRecords(Collection $records, array $groupFields): array
    {
        if (empty($groupFields)) {
            return $records->values()->all();
        }

        return $this->groupRecursive($records, $groupFields);
    }

    protected function groupRecursive(Collection $records, array $groupFields): array
    {
        if (empty($groupFields)) {
            return $records->values()->all();
        }

        $currentField = array_shift($groupFields);
        $grouped = $records->groupBy(function (array $row) use ($currentField) {
            $value = $row[$currentField] ?? null;
            return $value === null || $value === '' ? 'N/A' : (string) $value;
        });

        $result = [];
        foreach ($grouped as $value => $items) {
            $node = [
                'group' => $currentField,
                'value' => $value,
                'count' => $items->count(),
                'total_approved' => $this->sumField($items, 'approved_amount'),
                'total_paid' => $this->sumField($items, 'paid_amount'),
            ];

            if (!empty($groupFields)) {
                $node['children'] = $this->groupRecursive($items, $groupFields);
            } else {
                $node['records'] = $items->values()->all();
            }

            $result[] = $node;
        }

        return $result;
    }

    protected function sumField(Collection $items, string $field): float
    {
        return (float) $items->sum(function (array $row) use ($field) {
            $value = $row[$field] ?? 0;
            return is_numeric($value) ? (float) $value : 0;
        });
    }

    protected function normalizeFilters(array $filters): array
    {
        if (empty($filters)) {
            return [];
        }

        $isList = array_keys($filters) === range(0, count($filters) - 1);
        if ($isList) {
            return array_values(array_filter(array_map(function ($filter) {
                if (!is_array($filter)) {
                    return null;
                }
                $field = $filter['field'] ?? null;
                $value = $filter['value'] ?? null;
                if (!$field) {
                    return null;
                }
                return [
                    'field' => $field,
                    'operator' => $filter['operator'] ?? '=',
                    'value' => $value,
                ];
            }, $filters)));
        }

        $normalized = [];
        foreach ($filters as $field => $value) {
            $normalized[] = [
                'field' => $field,
                'operator' => '=',
                'value' => $value,
            ];
        }

        return $normalized;
    }

    protected function passesFilter($rowValue, string $operator, $value): bool
    {
        $operator = strtolower(trim($operator));

        if ($operator === 'like' || $operator === 'contains') {
            return stripos((string) $rowValue, (string) $value) !== false;
        }

        $left = $rowValue;
        $right = $value;
        $numeric = is_numeric($left) && is_numeric($right);
        if ($numeric) {
            $left = (float) $left;
            $right = (float) $right;
        }

        return match ($operator) {
            '!=' => $left != $right,
            '>' => $left > $right,
            '<' => $left < $right,
            '>=' => $left >= $right,
            '<=' => $left <= $right,
            default => $left == $right,
        };
    }
}
