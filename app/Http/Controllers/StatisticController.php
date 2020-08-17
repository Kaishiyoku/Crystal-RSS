<?php

namespace App\Http\Controllers;

use App\Models\ReportFeedItem;
use Illuminate\Support\Carbon;
use Kaishiyoku\LaravelRecharts\LaravelRecharts;
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

        $elements = [
            LaravelRecharts::element(__('statistic.index.articles'), LaravelRecharts::TYPE_BAR, 'rgba(105, 39, 255, .5)'),
            LaravelRecharts::element(__('statistic.index.read_articles'), LaravelRecharts::TYPE_LINE, 'rgba(213, 64, 98, .5)'),
        ];
        $data = $items->map(function ($item) {
            return LaravelRecharts::dataEntry($item['posted_at'], [
                __('statistic.index.articles') => $item['numberOfArticles'],
                __('statistic.index.read_articles') => $item['numberOfReadArticles'],
            ]);
        });

        $laravelRecharts = new LaravelRecharts();
        $dailyArticlesChart = $laravelRecharts->makeChart($elements, $data->toArray(), 375);

        return $dailyArticlesChart;
    }
}
