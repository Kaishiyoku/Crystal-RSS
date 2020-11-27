<?php

namespace App\Console\Commands;

use App\Models\FeedItem;
use App\Models\ReportFeedItem;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class MigrateReportFeedItems extends Command
{
    private const DATE = 'Y-m-d';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:feed-items {--latest}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all feed items into the report table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $latestOnly = $this->option('latest');
        $yesterday = now()->subDay()->endOfDay();
        $latestDays = 7;

        $users = User::all();

        $users->each(function (User $user) use ($latestOnly, $yesterday, $latestDays) {
            $this->line('----- ' . $user->name . ' -----');

            $feedItems = $user->feedItems()->select(['user_id', 'posted_at', 'read_at']);

            if ($latestOnly) {
                $feedItems = $feedItems->whereDate('posted_at', '>=', now()->subDays($latestDays));
            }

            $feedItems = $feedItems
                ->whereDate('posted_at', '<=', $yesterday)
                ->get()
                ->sortBy('posted_at')
                ->filter(function (FeedItem $feedItem) {
                    return $feedItem->posted_at->format(self::DATE) !== now()->format(self::DATE);
                });

            $totalCounts = $feedItems
                ->groupBy(function (FeedItem $feedItem) {
                    return $feedItem->posted_at->format(self::DATE);
                })
                ->map(function (Collection $feedItems) {
                    return $feedItems->count();
                });

            $readCounts = $feedItems
                ->filter(function (FeedItem $feedItem) {
                    return $feedItem->read_at !== null;
                })
                ->groupBy(function (FeedItem $feedItem) {
                    return $feedItem->read_at->format(self::DATE);
                })
                ->map(function (Collection $feedItems) {
                    return $feedItems->count();
                });

            $totalCounts->each(function ($totalCount, $date) use ($readCounts, $user) {
                $readCount = $readCounts->get($date) ?: 0;

                $this->line($date . ' -> total: ' . $totalCount . ' read: ' . $readCount);

                $existingReportFeedItem = $user->reportFeedItems()->where('date', $date)->first();

                if ($existingReportFeedItem === null) {
                    $reportFeedItem = new ReportFeedItem();
                    $reportFeedItem->date = $date;
                    $reportFeedItem->total_count = $totalCount;
                    $reportFeedItem->read_count = $readCount;

                    $user->reportFeedItems()->save($reportFeedItem);
                }
            });

            $this->line('');
        });

        return 0;
    }
}
