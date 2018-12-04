<?php

namespace App\Http\Controllers;

use App\Charts\DailyArticlesChart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index()
    {
        // TODO: fill gaps
        $feedItems = auth()->user()->feedItems(false)->where('date', '>=', Carbon::now()->subMonth())
                            ->where('date', '<=', Carbon::now())
                            ->orderBy('fetch_date')
                            ->get([
                                'id',
                                'read_at',
                                DB::raw('Date(date) as fetch_date'),
                            ]);

        $feedItems = $feedItems->groupBy('fetch_date');

        $feedItemValues = $feedItems->map(function ($items) {
            return $items->count();
        });

        $dailyArticlesChart = new DailyArticlesChart();
        $dailyArticlesChart->title('Articles of the last 31 days');

        $dailyArticlesChart->labels($feedItemValues->keys());
        $dailyArticlesChart->dataset('Total articles', 'bar', $feedItemValues->values())->options([
            'backgroundColor' => config('charts.colors')[0],
        ]);

        return view('statistic.index', compact('dailyArticlesChart'));
    }
}