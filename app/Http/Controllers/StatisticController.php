<?php

namespace App\Http\Controllers;

use App\Charts\DailyArticlesChart;
use App\Models\ReportFeedItem;
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
            ->where('posted_at', '>=', $minDate)
            ->where('posted_at', '<=', $maxDate)
            ->whereNotNull('read_at')
            ->get([
                'posted_at',
                'read_at'
            ]);

        $averageTimeInSecondsBetweenRetrievalAndRead = round($feedItems->map(function ($feedItem) {
            return $feedItem->posted_at->diffInSeconds($feedItem->read_at);
        })->average());

        $averageDurationBetweenRetrievalAndRead = new Duration($averageTimeInSecondsBetweenRetrievalAndRead);

        $categories = auth()->user()->categories()->with('feeds')->get();

        return view('statistic.index', compact('dailyArticlesChart', 'averageDurationBetweenRetrievalAndRead', 'categories'));
    }

    private function getDailyArticlesChart($minDate, $maxDate)
    {
        $reportFeedItems = auth()->user()->reportFeedItems()
            ->where('date', '>=', $minDate)
            ->where('date', '<=', $maxDate);

        $items = $reportFeedItems->get()->map(function (ReportFeedItem $reportFeedItem) {
            return [
                'posted_at' => $reportFeedItem->date->formatLocalized(__('common.localized_date_formats.date_with_day_of_week')),
                'numberOfArticles' => $reportFeedItem->total_count,
                'numberOfReadArticles' => $reportFeedItem->read_count,
            ];
        });

        $dailyArticlesChart = new DailyArticlesChart();
        $dailyArticlesChart->type('bar');
        $dailyArticlesChart->options([
            'tooltips' => [
                'mode' => 'point',
            ],
        ]);

        $dailyArticlesChart->labels($items->pluck('posted_at'));
        $dailyArticlesChart->dataset(__('statistic.index.articles'), 'bar', $items->pluck('numberOfArticles'));
        $dailyArticlesChart->dataset(__('statistic.index.read_articles'), 'line', $items->pluck('numberOfReadArticles'))->options([
            'fill' => false,
        ]);

        return $dailyArticlesChart;
    }
}
