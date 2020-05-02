<?php

namespace App\Console;

use App\Console\Commands\UpdateFeed;
use App\Enums\Weekday;
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
        Commands\UpdateFeed::class,
        Commands\MigrateReportFeedItems::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        switch (env('UPDATE_INTERVAL')) {
            case '5_MINUTES':
                $schedule->command(UpdateFeed::class)->everyFiveMinutes()->sendOutputTo('storage/logs/feed_updates.log');
                break;
            case '10_MINUTES':
                $schedule->command(UpdateFeed::class)->everyTenMinutes()->sendOutputTo('storage/logs/feed_updates.log');
                break;
            case '30_MINUTES':
                $schedule->command(UpdateFeed::class)->everyThirtyMinutes()->sendOutputTo('storage/logs/feed_updates.log');
                break;
            case 'HOURLY':
                $schedule->command(UpdateFeed::class)->hourlyAt(0)->sendOutputTo('storage/logs/feed_updates.log');
                break;
            default:
                $schedule->command(UpdateFeed::class)->everyThirtyMinutes()->sendOutputTo('storage/logs/feed_updates.log');
        }

        $schedule->command('statistics:migrate --latest')->dailyAt('01:00');
        $schedule->command('statistics:migrate')->weeklyOn(Weekday::SUNDAY, '04:00');

        $schedule->command('feed:check')->dailyAt('02:00');

        $schedule->command('backup:clean')->daily()->at('04:00');
        $schedule->command('backup:run')->daily()->at('05:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
