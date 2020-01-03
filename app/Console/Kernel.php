<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

        'App\Console\Commands\BlueRockTELProduceVitalPbxCdrCommand',

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $start = now()->subDays(1)->startOfDay()->format('Y-m-d');

        $end = now()->subDays(1)->endOfDay()->format('Y-m-d');

        $schedule->command('brtel:produceVitalPbxCdr', [

            'start' => $start,
            'end' => $end,

        ])->dailyAt('03:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
