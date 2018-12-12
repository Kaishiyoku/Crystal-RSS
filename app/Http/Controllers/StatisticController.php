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
        $items = $items->map(function (Carbon $date) use ($feedItems) {
            $items = $feedItems->filter(function ($feedItem) use ($date) {
                return $feedItem->date->between($date->copy()->startOfDay(), $date->copy()->endOfDay());
            });

            return [
                'date' => $date->format(l(DATE)),
                'numberOfArticles' => $items->count(),
                'numberOfReadArticles' => auth()->user()->feedItems(false)
                    ->where('read_at', '>=', $date->copy()->startOfDay())
                    ->where('read_at', '<=', $date->copy()->endOfDay())
                    ->whereNotNull('read_at')
                    ->count(),
            ];
        });

        $dailyArticlesChart = new DailyArticlesChart();
        $dailyArticlesChart->title(__('statistic.index.articles_of_the_last_month'));
        $dailyArticlesChart->type('bar');
        $dailyArticlesChart->options([
            'tooltips' => [
                'mode' => 'point'
            ]
        ]);

        $dailyArticlesChart->labels($items->pluck('date'));
        $dailyArticlesChart->dataset(__('statistic.index.articles'), 'bar', $items->pluck('numberOfArticles'))->options([
//            'borderColor' => config('charts.colors')[0],
//            'backgroundColor' => config('charts.colors')[0],
        ]);
        $dailyArticlesChart->dataset(__('statistic.index.read_articles'), 'line', $items->pluck('numberOfReadArticles'))->options([
//            'borderColor' => config('charts.colors')[1],
            'fill' => false,
        ]);

        return $dailyArticlesChart;
    }
}