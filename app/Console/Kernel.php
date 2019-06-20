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
        $schedule->command('notifier:momo')->everyFiveMinutes();
        $this->backupDatabase($schedule);
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

    private function backupDatabase(Schedule $schedule)
    {
        $dbName = env('DB_DATABASE');
        $dbPass = env('DB_PASSWORD');
        $dbUser = env('DB_USERNAME');
        $dbHost = env('DB_HOST');
        $time = date('YmdHi');
        $schedule->exec("mysqldump -p{$dbPass} -u {$dbUser} -h {$dbHost} {$dbName} > /root/backup/{$dbName}_{$time}.sql")->twiceDaily();
    }
}
