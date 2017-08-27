<?php

namespace App\Console;

use App\Console\Commands\UpdateFeeds;
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
        Commands\UpdateFeeds::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        switch (env('UPDATE_INTERVAL')) {
            case '5_MINUTES':
                $schedule->command(UpdateFeeds::class)->everyFiveMinutes()->sendOutputTo('storage/logs/feed_updates.log');
                break;
            case '10_MINUTES':
                $schedule->command(UpdateFeeds::class)->everyTenMinutes()->sendOutputTo('storage/logs/feed_updates.log');
                break;
            case '30_MINUTES':
                $schedule->command(UpdateFeeds::class)->everyThirtyMinutes()->sendOutputTo('storage/logs/feed_updates.log');
                break;
            case 'HOURLY':
                $schedule->command(UpdateFeeds::class)->hourlyAt(0)->sendOutputTo('storage/logs/feed_updates.log');
                break;
            default:
                $schedule->command(UpdateFeeds::class)->everyThirtyMinutes()->sendOutputTo('storage/logs/feed_updates.log');
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
