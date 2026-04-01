<?php

namespace App\Services;

use Illuminate\Support\Collection;

class RepaymentInstallmentResolver
{
    public static function resolve(iterable|string|null $chequeDetails, float $totalRepaid): Collection
    {
        if (is_string($chequeDetails)) {
            $decoded = json_decode($chequeDetails, true);
            $chequeDetails = is_array($decoded) ? $decoded : [];
        }

        $items = collect($chequeDetails ?? [])
            ->filter(fn($item) => is_array($item))
            ->map(function (array $item, int $index) {
                return (object) [
                    'installment_no' => (int) ($item['row_number'] ?? ($index + 1)),
                    'repayment_date' => $item['cheque_date'] ?? null,
                    'cheque_date' => $item['cheque_date'] ?? null,
                    'amount' => (float) ($item['amount'] ?? 0),
                    'cheque_number' => $item['cheque_number'] ?? null,
                    'bank_name' => $item['bank_name'] ?? null,
                    'ifsc' => $item['ifsc'] ?? null,
                    'account_number' => $item['account_number'] ?? null,
                    'parents_jnt_ac_name' => $item['parents_jnt_ac_name'] ?? null,
                ];
            })
            ->sortBy('installment_no')
            ->values();

        $remainingPaidAmount = $totalRepaid;

        return $items->map(function ($installment) use (&$remainingPaidAmount) {
            $installmentAmount = (float) $installment->amount;

            if ($installmentAmount > 0 && $remainingPaidAmount >= $installmentAmount) {
                $installment->status = 'paid';
                $remainingPaidAmount -= $installmentAmount;
            } elseif ($installmentAmount > 0 && $remainingPaidAmount > 0) {
                $installment->status = 'partial';
                $remainingPaidAmount = 0;
            } else {
                $installment->status = 'pending';
            }

            return $installment;
        });
    }
}
