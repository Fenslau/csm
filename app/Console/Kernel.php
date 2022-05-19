<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

     protected $commands = [
         Commands\Journal\HolodEmail::class,
         Commands\Journal\LampaEmail::class,
         Commands\Journal\LampaNarabotkaEmail::class,

     ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('holod:email')->dailyAt('20:00')->runInBackground()->appendOutputTo('storage/logs/HolodEmail.log');
        $schedule->command('lampa:email')->dailyAt('20:00')->runInBackground()->appendOutputTo('storage/logs/LampaEmail.log');
        $schedule->command('lampanarabotka:email')->dailyAt('20:00')->runInBackground()->appendOutputTo('storage/logs/LampaNarabotkaEmail.log');
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
