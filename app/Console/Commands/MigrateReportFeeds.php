<?php

namespace App\Console\Commands;

use App\Enums\VoteStatus;
use App\Http\Controllers\StatisticController;
use App\Models\Category;
use App\Models\Feed;
use App\Models\FeedItem;
use App\Models\ReportFeed;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class MigrateReportFeeds extends Command
{
    private const DATE = 'Y-m-d';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:feeds {--latest}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $latestOnly = $this->option('latest');
        $yesterday = now()->subDay()->endOfDay();
        $latestDays = 7;

        $users = User::all();

        $users->each(function (User $user) use ($latestOnly, $yesterday, $latestDays) {
            $this->line('----- ' . $user->name . ' -----');

            $feeds = $user->feeds();

            $feeds->each(function (Feed $feed) use ($latestOnly, $yesterday, $latestDays, $user) {
                $feedItems = $feed->feedItems();

                if ($latestOnly) {
                    $feedItems = $feedItems->whereDate('posted_at', '>=', now()->subDays($latestDays));
                }

                $feedItems = $feedItems
                    ->whereDate('posted_at', '<=', $yesterday)
                    ->orderBy('posted_at')
                    ->get()
                    ->filter(function (FeedItem $feedItem) {
                        return $feedItem->posted_at->format(self::DATE) !== now()->format(self::DATE);
                    });

                $numberOfUpvotes = $feedItems->filter(function (FeedItem $feedItem) {
                    return $feedItem->vote_status === VoteStatus::Up;
                })->count();
                $numberOfDownvotes = $feedItems->filter(function (FeedItem $feedItem) {
                    return $feedItem->vote_status === VoteStatus::Down;
                })->count();

                $existingReportFeed = $user->reportFeeds()->where('feed_id', $feed->id)->first();

                if ($existingReportFeed === null) {
                    $existingReportFeed = new ReportFeed();
                    $existingReportFeed->feed_id = $feed->id;
                    $existingReportFeed->upvotes = $numberOfUpvotes;
                    $existingReportFeed->downvotes = $numberOfDownvotes;
                    $existingReportFeed->feed_items_count = $feedItems->count();
                } else {
                    $existingReportFeed->upvotes = $existingReportFeed->upvotes + $numberOfUpvotes;
                    $existingReportFeed->downvotes = $existingReportFeed->downvotes + $numberOfDownvotes;
                    $existingReportFeed->feed_items_count = $existingReportFeed->feed_items_count + $feedItems->count();
                }

                $user->reportFeeds()->save($existingReportFeed);
            });

            Cache::rememberForever(StatisticController::getCategoriesCacheKeyFor($user), function () use ($user) {
                return $user->categories()
                    ->with('feeds', 'feeds.reportFeeds')
                    ->get()
                    ->map(function (Category $category) use ($user) {
                        $category->total_feed_items_count = $category->getTotalFeedItemsCount();
                        $category->total_upvote_count = $category->getTotalUpVoteCount();
                        $category->total_downvote_count = $category->getTotaldownVoteCount();
                        $category->style = $category->getStyle();

                        $category->feeds->map(function (Feed $feed) use ($user) {
                            $feed->total_feed_items_count = $feed->reportFeeds->sum('feed_items_count');
                            $feed->total_upvote_count = $feed->reportFeeds->sum('upvotes');
                            $feed->total_downvote_count = $feed->reportFeeds->sum('downvotes');
                            $feed->style = $feed->getStyle();

                            return $feed;
                        });

                        return $category;
                    });
            });
        });

        return 0;
    }
}
