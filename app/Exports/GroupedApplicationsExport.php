<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupedApplicationsExport implements FromArray, WithHeadings
{
    protected array $groupedData;
    protected array $columns;
    protected array $labels;

    public function __construct(array $groupedData, array $columns, array $labels)
    {
        $this->groupedData = $groupedData;
        $this->columns = $columns;
        $this->labels = $labels;
    }

    public function headings(): array
    {
        return array_merge(
            ['Type', 'Level', 'Group', 'Value', 'Count', 'Total Approved', 'Total Paid'],
            array_map(fn ($col) => $this->labels[$col] ?? $col, $this->columns)
        );
    }

    public function array(): array
    {
        $rows = [];

        if ($this->isGrouped($this->groupedData)) {
            $this->appendGroupRows($rows, $this->groupedData, 0);
            return $rows;
        }

        foreach ($this->groupedData as $record) {
            $rows[] = $this->buildRecordRow($record, 0);
        }

        return $rows;
    }

    protected function appendGroupRows(array &$rows, array $nodes, int $level): void
    {
        foreach ($nodes as $node) {
            $rows[] = $this->buildGroupRow($node, $level);

            if (!empty($node['children'])) {
                $this->appendGroupRows($rows, $node['children'], $level + 1);
                continue;
            }

            if (!empty($node['records'])) {
                foreach ($node['records'] as $record) {
                    $rows[] = $this->buildRecordRow($record, $level + 1);
                }
            }
        }
    }

    protected function buildGroupRow(array $node, int $level): array
    {
        $row = [
            'GROUP',
            $level,
            $node['group'] ?? '',
            $node['value'] ?? '',
            $node['count'] ?? 0,
            $node['total_approved'] ?? 0,
            $node['total_paid'] ?? 0,
        ];

        foreach ($this->columns as $col) {
            $row[] = '';
        }

        return $row;
    }

    protected function buildRecordRow(array $record, int $level): array
    {
        $row = [
            'RECORD',
            $level,
            '',
            '',
            '',
            '',
            '',
        ];

        foreach ($this->columns as $col) {
            $row[] = $record[$col] ?? '';
        }

        return $row;
    }

    protected function isGrouped(array $data): bool
    {
        if (empty($data)) {
            return false;
        }
        $first = $data[0] ?? null;
        return is_array($first) && array_key_exists('group', $first);
    }
}
