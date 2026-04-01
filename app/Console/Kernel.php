<?php

namespace App\Console;

use App\Console\Commands\SendRepaymentReminder;
use App\Console\Commands\SendThirdStageDocumentReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SendThirdStageDocumentReminder::class,
        SendRepaymentReminder::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('third-stage-documents:send-reminder')->everyMinute();
        // $schedule->command('repayment:send-reminder')->dailyAt('08:00');
        $schedule->command('repayment:send-reminder')->everyMinute();
        
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
