<?php

namespace App\Console\Commands;

use App\Mail\ThirdStageDocumentReminderMail;
use App\Models\ApplicationWorkflowStatus;
use App\Models\ThirdStageDocument;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendThirdStageDocumentReminder extends Command
{
    protected $signature = 'third-stage-documents:send-reminder';

    protected $description = 'Send reminder email for 3rd Stage Documents one month before second disbursement';

    public function handle(): int
    {
        $today = Carbon::today();

        $secondSchedules = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('installment_no', 2)
            ->get();

        foreach ($secondSchedules as $schedule) {
            if (empty($schedule->planned_date)) {
                continue;
            }

            $secondDate = Carbon::parse($schedule->planned_date)->startOfDay();
            $notifyDate = $secondDate->copy()->subMonth();

            if (!$notifyDate->isSameDay($today)) {
                continue;
            }

            $firstCompleted = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->where('user_id', $schedule->user_id)
                ->where('installment_no', 1)
                ->where('status', 'completed')
                ->exists();

            if (!$firstCompleted) {
                continue;
            }

            $workflow = ApplicationWorkflowStatus::where('user_id', $schedule->user_id)->first();
            if (!$workflow || $workflow->third_stage_notification_sent_at) {
                continue;
            }

            $user = User::find($schedule->user_id);
            if (!$user || empty($user->email)) {
                continue;
            }

            $thirdStageDocument = ThirdStageDocument::firstOrCreate(
                ['user_id' => $schedule->user_id],
                ['status' => 'pending']
            );

            $thirdStageDocument->update([
                'notification_sent_at' => $today,
                'status' => $thirdStageDocument->status ?: 'pending',
            ]);

            $workflow->update([
                'third_stage_notification_sent_at' => $today,
            ]);

            try {
                Mail::to($user->email)->send(new ThirdStageDocumentReminderMail($user, $secondDate));
            } catch (\Throwable $e) {
                Log::error('Third stage reminder email failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
                continue;
            }
        }

        return Command::SUCCESS;
    }
}
