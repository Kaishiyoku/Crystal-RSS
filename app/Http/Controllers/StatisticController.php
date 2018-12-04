<?php

namespace App\Http\Controllers;

use App\Charts\DailyArticlesChart;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Khill\Duration\Duration;

class StatisticController extends Controller
{
    public function index()
    {
        $minDate = Carbon::now()->subMonth()->startOfDay();
        $maxDate = Carbon::now()->endOfDay();

        $dailyArticlesChart = $this->getDailyArticlesChart($minDate, $maxDate);

        $feedItems = auth()->user()->feedItems(false)
            ->where('date', '>=', $minDate)
            ->where('date', '<=', $maxDate)
            ->whereNotNull('read_at')
            ->get([
                'date',
                'read_at'
            ]);

        $averageTimeInSecondsBetweenRetrievalAndRead = round($feedItems->map(function ($feedItem) {
            return $feedItem->date->diffInSeconds($feedItem->read_at);
        })->average());

        $averageDurationBetweenRetrievalAndRead = new Duration($averageTimeInSecondsBetweenRetrievalAndRead);

        return view('statistic.index', compact('dailyArticlesChart', 'averageDurationBetweenRetrievalAndRead'));
    }

    private function getDailyArticlesChart($minDate, $maxDate)
    {
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

            return [$date->format(l(DATE)) => $items->count()];
        });

        $dailyArticlesChart = new DailyArticlesChart();
        $dailyArticlesChart->title(__('statistic.index.articles_of_the_last_month'));

        $dailyArticlesChart->labels($items->keys());
        $dailyArticlesChart->dataset(__('statistic.index.articles'), 'bar', $items->values())->options([
            'backgroundColor' => config('charts.colors')[0],
        ]);

        return $dailyArticlesChart;
    }
}