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

        $categories = auth()->user()->categories()->with('feeds')->get();

        return view('statistic.index', compact('dailyArticlesChart', 'averageDurationBetweenRetrievalAndRead', 'categories'));
    }

    private function getDailyArticlesChart($minDate, $maxDate)
    {
        $carbonPeriod = collect(CarbonPeriod::create($minDate, $maxDate)->toArray());

        $items = $carbonPeriod->map(function (Carbon $date) {
            $currentItems = auth()->user()->feedItems(false)
                ->where('date', '>=', $date->copy()->startOfDay())
                ->where('date', '<=', $date->copy()->endOfDay())
                ->orderBy('date');

            $currentReadItems = auth()->user()->feedItems(false)
                ->where('read_at', '>=', $date->copy()->startOfDay())
                ->where('read_at', '<=', $date->copy()->endOfDay())
                ->whereNotNull('read_at');

            return [
                'date' => $date->format(l(DATE)),
                'numberOfArticles' => $currentItems->count(),
                'numberOfReadArticles' => $currentReadItems->count(),
            ];
        });

        $dailyArticlesChart = new DailyArticlesChart();
        $dailyArticlesChart->type('bar');
        $dailyArticlesChart->options([
            'tooltips' => [
                'mode' => 'point'
            ]
        ]);

        $dailyArticlesChart->labels($items->pluck('date'));
        $dailyArticlesChart->dataset(__('statistic.index.articles'), 'bar', $items->pluck('numberOfArticles'));
        $dailyArticlesChart->dataset(__('statistic.index.read_articles'), 'line', $items->pluck('numberOfReadArticles'))->options([
            'fill' => false,
        ]);

        return $dailyArticlesChart;
    }
}
