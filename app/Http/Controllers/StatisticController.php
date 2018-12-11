<?php

namespace App\Http\Controllers;

use App\Charts\CategoriesChart;
use App\Charts\DailyArticlesChart;
use App\Models\Category;
use App\Models\Feed;
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
        $categoriesChart = $this->getCategoriesChart();

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

        return view('statistic.index', compact('dailyArticlesChart', 'averageDurationBetweenRetrievalAndRead', 'categoriesChart'));
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
        $dailyArticlesChart->dataset(__('statistic.index.articles'), 'line', $items->values())->options([
            'backgroundColor' => config('charts.colors')[0],
        ]);

        return $dailyArticlesChart;
    }

    private function getCategoriesChart()
    {
        $categoriesChart = new CategoriesChart();

        $items = Category::withCount('feeds')->get();

        $categoriesChart->labels($items->map(function ($item) {
            return $item->title;
        }));

        $categoriesChart->dataset('Anzahl Feeds', 'bar', $items->map(function ($item) {
            return $item->feeds_count;
        }));

        $categoriesChart->dataset('Anzahl Artikel', 'bar', $items->map(function ($item) {
            return $item->feeds->map(function (Feed $feed) {
                return $feed->feedItems->count();
            });
        }));

        return $categoriesChart;
    }
}