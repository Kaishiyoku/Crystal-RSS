<?php

namespace App\Http\Controllers;

use App\Charts\DailyArticlesChart;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;

class StatisticController extends Controller
{
    public function index()
    {
        $dailyArticlesChart = $this->getDailyArticlesChart();

        return view('statistic.index', compact('dailyArticlesChart'));
    }

    private function getDailyArticlesChart()
    {
        $minDate = Carbon::now()->subMonth()->startOfDay();
        $maxDate = Carbon::now()->endOfDay();
        $feedItems = auth()->user()->feedItems(false)
            ->where('date', '>=', $minDate)
            ->where('date', '<=', $maxDate)
            ->orderBy('date')
            ->get([
                'date'
            ]);

        $items = collect(CarbonPeriod::create($minDate, $maxDate)->toArray());
        $items = $items->mapWithKeys(function (Carbon $date) use ($feedItems) {
            $items = $feedItems->filter(function ($feedItem) use ($date) {
                return $feedItem->date->between($date->copy()->startOfDay(), $date->copy()->endOfDay());
            });

            return [$date->format('Y-m-d') => $items->count()];
        });


        $dailyArticlesChart = new DailyArticlesChart();
        $dailyArticlesChart->title('Articles of the last 31 days');

        $dailyArticlesChart->labels($items->keys());
        $dailyArticlesChart->dataset('Total articles', 'bar', $items->values())->options([
            'backgroundColor' => config('charts.colors')[0],
        ]);

        return $dailyArticlesChart;
    }
}