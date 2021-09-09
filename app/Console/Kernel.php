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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('t2g_common:momo:notifier')->everyFiveMinutes();
        $schedule->command('t2g_common:mysql:backup mysql')->hourly();
        $schedule->command('t2g_common:ccu:update')->everyFiveMinutes();
        $schedule->command('t2g_common:users:update_last_login')->dailyAt("02:00");
        $schedule->command('t2g_common:monitor:gold')->everyFiveMinutes();
        $schedule->command('t2g_common:monitor:gold_gm')->everyFiveMinutes();
        $schedule->command('t2g_common:monitor:gold_trading')->everyThirtyMinutes();
        $schedule->command('t2g_common:monitor:money_trading 10')->everyThirtyMinutes();
        $schedule->command('t2g_common:monitor:multiple_login 12')->everyTenMinutes();
        $schedule->command('t2g_common:monitor:multiple_pc_pm 10 --ban 1')->everyTenMinutes();
        $schedule->command('t2g_common:monitor:kimyen_keoxe')->everyThirtyMinutes();
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
