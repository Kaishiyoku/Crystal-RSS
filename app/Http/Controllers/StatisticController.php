<?php

namespace App\Http\Controllers;

use App\Charts\DailyArticlesChart;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
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
        $carbonPeriod = collect(CarbonPeriod::create($minDate, $maxDate)->toArray());

        $items = $carbonPeriod->map(function (Carbon $date) {
            /*** @var User $user */
            $user = auth()->user();

            $currentItemsCount = self::getCurrentItemsForChartCount($user, $date);
            $currentReadItemsCount = self::getCurrentReadItemsForChartCount($user, $date);

            return [
                'posted_at' => $date->format(l(DATE)),
                'numberOfArticles' => $currentItemsCount,
                'numberOfReadArticles' => $currentReadItemsCount,
            ];
        });

        $dailyArticlesChart = new DailyArticlesChart();
        $dailyArticlesChart->type('bar');
        $dailyArticlesChart->options([
            'tooltips' => [
                'mode' => 'point'
            ]
        ]);

        $dailyArticlesChart->labels($items->pluck('posted_at'));
        $dailyArticlesChart->dataset(__('statistic.index.articles'), 'bar', $items->pluck('numberOfArticles'));
        $dailyArticlesChart->dataset(__('statistic.index.read_articles'), 'line', $items->pluck('numberOfReadArticles'))->options([
            'fill' => false,
        ]);

        return $dailyArticlesChart;
    }

    /**
     * @param User $user
     * @param Carbon $date
     * @return Relation
     */
    public static function getCurrentItemsForChartCount(User $user, Carbon $date)
    {
        $cacheKey = $user->id . '-' . config('model_cache.statistics.feed_items.prefix') . '-current_items_for_chart-' . $date;

        return Cache::remember($cacheKey, config('model_cache.statistics.feed_items.duration'), function () use ($user, $date) {
            return $user->feedItems(false)
                ->where('posted_at', '>=', $date->copy()->startOfDay())
                ->where('posted_at', '<=', $date->copy()->endOfDay())
                ->orderBy('posted_at')
//                ->remember(config('model_cache.statistics.feed_items.duration'))
                ->prefix(config('model_cache.statistics.feed_items.prefix'))
                ->count();
        });
    }

    /**
     * @param User $user
     * @param Carbon $date
     * @return Relation
     */
    public static function getCurrentReadItemsForChartCount(User $user, Carbon $date)
    {
        $cacheKey = $user->id . '-' . config('model_cache.statistics.feed_items.prefix') . '-current_read_items_for_chart-' . $date;

        return Cache::remember($cacheKey, config('model_cache.statistics.feed_items.duration'), function () use ($user, $date) {
            return $user->feedItems(false)
                ->where('read_at', '>=', $date->copy()->startOfDay())
                ->where('read_at', '<=', $date->copy()->endOfDay())
                ->whereNotNull('read_at')
//                ->remember(config('model_cache.statistics.feed_items.duration'))
                ->prefix(config('model_cache.statistics.feed_items.prefix'))
                ->count();
        });
    }
}
