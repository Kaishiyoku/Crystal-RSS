<?php

namespace App\Http\Controllers;

use App\Models\ReportFeedItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Kaishiyoku\LaravelRecharts\LaravelRecharts;

class StatisticController extends Controller
{
    public const CATEGORIES_CACHE_KEY = 'statistic_categories';

    public const AVERAGE_DURATION_BETWEEN_RETRIEVAL_AND_READ_CACHE_KEY = 'average_duration_between_retrieval_and_read_cache_key';

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

        $reportFeedItems = auth()->user()->reportFeedItems()
            ->where('date', '>=', $startingDate)
            ->where('date', '<=', $endingDate);
        $feedItemsCount = $reportFeedItems->count();

        $dailyArticlesChart = $this->getDailyArticlesChart($reportFeedItems, $startingDate, $endingDate);

        $categories = self::getCategoriesWithFeedData(auth()->user()) ?? collect();

        $averageDurationBetweenRetrievalAndRead = self::getAverageDurationBetweenRetrievalAndRead(auth()->user());

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

    private function getDailyArticlesChart($reportFeedItems, $startingDate, $endingDate)
    {
        $items = $reportFeedItems->get()->map(function (ReportFeedItem $reportFeedItem) {
            return [
                'posted_at' => $reportFeedItem->date->formatLocalized(__('common.localized_date_formats.date_with_day_of_week')),
                'numberOfArticles' => $reportFeedItem->total_count,
                'numberOfReadArticles' => $reportFeedItem->read_count,
            ];
        });

        $elements = [
            LaravelRecharts::element(__('statistic.index.articles'), LaravelRecharts::TYPE_BAR, 'rgba(105, 39, 255, .6)'),
            LaravelRecharts::element(__('statistic.index.read_articles'), LaravelRecharts::TYPE_AREA, 'rgba(219, 23, 255, .4)'),
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

    public static function getCategoriesWithFeedData($user)
    {
        return Cache::get(self::getCategoriesCacheKeyFor($user));
    }

    public static function getCategoriesCacheKeyFor($user)
    {
        return self::CATEGORIES_CACHE_KEY . '.' . $user->id;
    }

    public static function getAverageDurationBetweenRetrievalAndRead($user)
    {
        return Cache::get(self::getAverageDurationBetweenRetrievalAndReadCacheKeyFor($user));
    }

    public static function getAverageDurationBetweenRetrievalAndReadCacheKeyFor($user)
    {
        return self::AVERAGE_DURATION_BETWEEN_RETRIEVAL_AND_READ_CACHE_KEY . '.' . $user->id;
    }
}
