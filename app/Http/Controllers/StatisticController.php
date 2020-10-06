<?php

namespace App\Http\Controllers;

use App\Models\ReportFeedItem;
use Illuminate\Support\Carbon;
use Kaishiyoku\LaravelRecharts\LaravelRecharts;
use Khill\Duration\Duration;

class StatisticController extends Controller
{
    public function index($startingYear = null, $startingMonth = null)
    {
        if (($startingYear && !$startingMonth) || ($startingMonth && ($startingYear < 2000 || $startingMonth < 1 || $startingMonth > 12))) {
            abort(422);
        }

        if ($startingYear == now()->year && $startingMonth == now()->month) {
            $startingYear = null;
            $startingMonth = null;
        }

        $startingDate = $startingYear !== null ? Carbon::create($startingYear, $startingMonth) : now()->subMonth()->startOfDay();
        $endingDate = $startingYear !== null ? $startingDate->copy()->endOfMonth()->endOfDay() : now()->endOfDay();

        if ($startingDate->isAfter(now())) {
            abort(422);
        }

        $previousDate = $startingYear !== null ? $startingDate->copy()->subMonth()->startOfMonth() : now()->subMonth()->startOfMonth();
        $nextDate = $startingYear !== null ? $startingDate->copy()->addMonth()->startOfMonth() : now()->addMonth()->startOfMonth();

        $dailyArticlesChart = $this->getDailyArticlesChart($startingDate, $endingDate);

        $feedItems = auth()->user()->feedItems(false)
            ->where('posted_at', '>=', $startingDate)
            ->where('posted_at', '<=', $endingDate)
            ->whereNotNull('read_at')
            ->get([
                'posted_at',
                'read_at'
            ]);
        $feedItemsCount = $feedItems->count();

        $averageTimeInSecondsBetweenRetrievalAndRead = round($feedItems->map(function ($feedItem) {
            return $feedItem->posted_at->diffInSeconds($feedItem->read_at);
        })->average());

        $averageDurationBetweenRetrievalAndRead = new Duration($averageTimeInSecondsBetweenRetrievalAndRead);

        $categories = auth()->user()->categories()->with('feeds')->get();

        return view('statistic.index', compact(
            'feedItemsCount',
            'dailyArticlesChart',
            'averageDurationBetweenRetrievalAndRead',
            'categories',
            'startingDate',
            'endingDate',
            'previousDate',
            'nextDate',
        ));
    }

    private function getDailyArticlesChart($startingDate, $endingDate)
    {
        $reportFeedItems = auth()->user()->reportFeedItems()
            ->where('date', '>=', $startingDate)
            ->where('date', '<=', $endingDate);

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
