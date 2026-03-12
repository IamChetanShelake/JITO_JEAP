<?php

namespace App\Console;

use App\Console\Commands\SendThirdStageDocumentReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SendThirdStageDocumentReminder::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('third-stage-documents:send-reminder')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
