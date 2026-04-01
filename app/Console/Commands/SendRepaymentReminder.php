<?php

namespace App\Console\Commands;

use App\Mail\RepaymentReminderMail;
use App\Models\PdcDetail;
use App\Models\RepaymentReminderLog;
use App\Models\User;
use App\Services\RepaymentInstallmentResolver;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRepaymentReminder extends Command
{
    protected $signature = 'repayment:send-reminder';

    protected $description = 'Send repayment reminder emails 15 days before pending installments are due';

    public function handle(): int
    {
        $timezone = config('app.timezone', 'UTC');
        $today = Carbon::today($timezone);

        $pdcDetails = PdcDetail::query()
            ->whereNotNull('cheque_details')
            ->get();

        foreach ($pdcDetails as $pdcDetail) {
            if (empty($pdcDetail->user_id)) {
                continue;
            }

            $user = User::find($pdcDetail->user_id);
            if (!$user || empty($user->email)) {
                continue;
            }

            $installments = RepaymentInstallmentResolver::resolve(
                $pdcDetail->cheque_details ?? [],
                $this->getTotalRepaid($pdcDetail->user_id)
            );

            foreach ($installments as $installment) {
                if ($installment->status === 'paid') {
                    continue;
                }

                $amount = (float) $installment->amount;
                if ($amount <= 0) {
                    continue;
                }

                if (empty($installment->repayment_date)) {
                    continue;
                }

                $repaymentDate = $this->parseDate($installment->repayment_date, $timezone);
                if (!$repaymentDate) {
                    continue;
                }

                $notifyDate = $repaymentDate->copy()->subDays(15);
                if (!$notifyDate->isSameDay($today)) {
                    continue;
                }

                $alreadySent = RepaymentReminderLog::where('user_id', $user->id)
                    ->where('installment_no', $installment->installment_no)
                    ->whereDate('repayment_date', $repaymentDate->toDateString())
                    ->exists();

                if ($alreadySent) {
                    continue;
                }

                Log::info('Sending repayment reminder', [
                    'user_id' => $user->id,
                    'installment_no' => $installment->installment_no,
                    'repayment_date' => $repaymentDate->toDateString(),
                    'amount' => $amount,
                ]);

                try {
                    Mail::to($user->email)->send(new RepaymentReminderMail($user, $repaymentDate, $amount));
                    Log::info('Repayment reminder email delivered', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'installment_no' => $installment->installment_no,
                        'repayment_date' => $repaymentDate->toDateString(),
                    ]);
                } catch (\Throwable $e) {
                    Log::error('Repayment reminder email failed', [
                        'user_id' => $user->id,
                        'installment_no' => $installment->installment_no,
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }

                RepaymentReminderLog::create([
                    'user_id' => $user->id,
                    'installment_no' => $installment->installment_no,
                    'repayment_date' => $repaymentDate->toDateString(),
                    'sent_at' => now(),
                ]);
            }
        }

        return Command::SUCCESS;
    }

    private function getTotalRepaid(int $userId): float
    {
        return (float) DB::connection('admin_panel')
            ->table('repayments')
            ->where('user_id', $userId)
            ->where('status', '!=', 'bounced')
            ->sum('amount');
    }

    private function parseDate($value, string $timezone): ?Carbon
    {
        try {
            return Carbon::parse($value, $timezone)->startOfDay();
        } catch (\Throwable) {
            return null;
        }
    }
}
