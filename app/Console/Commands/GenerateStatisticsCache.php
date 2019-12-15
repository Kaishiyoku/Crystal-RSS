<?php

namespace App\Console\Commands;

use App\Http\Controllers\StatisticController;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateStatisticsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate statistics cache.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $minDate = Carbon::now()->subMonth()->startOfDay();
        $maxDate = Carbon::now()->endOfDay();
        $carbonPeriod = collect(CarbonPeriod::create($minDate, $maxDate)->toArray());
        $users = User::all();

        $users->each(function (User $user) use ($carbonPeriod) {
            $carbonPeriod->map(function (Carbon $date) use ($user) {
                StatisticController::getCurrentItemsForChartCount($user, $date);
                StatisticController::getCurrentReadItemsForChartCount($user, $date);
            });
        });
    }
}
