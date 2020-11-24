<?php

namespace App\Console\Commands;

use App\Jobs\StoreRssFeedItem;
use App\Models\Feed;
use App\Models\UpdateLog;
use App\Models\User;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Kaishiyoku\HeraRssCrawler\HeraRssCrawler;
use Kaishiyoku\HeraRssCrawler\Models\Rss\Feed as RssFeed;
use Kaishiyoku\HeraRssCrawler\Models\Rss\FeedItem as RssFeedItem;

class UpdateFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:update {user? : The ID of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all RSS feeds.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);

        $this->info(__('feed.updating_at', ['date' => Carbon::now()]));
        $this->info('');

        $users = collect();

        if (empty($this->argument('user'))) {
            $users = User::active()->orderBy('name')->get();
        } else {
            $users->push(User::findOrFail($this->argument('user')));
        }

        $newLastCheckedAt = now();

        $users->each(function (User $user) use ($start, $newLastCheckedAt) {
            $totalNumberOfNewUnreadFeedItemsForUser = 0;

            $this->comment(__('feed.updating_feed_for_user', ['name' => $user->name]));
            $this->info('');

            $user->feeds()->enabled()->withTrashed()->orderBy('title')->get()->each(function (Feed $feed) use (&$user, &$totalNumberOfNewUnreadFeedItemsForUser, $newLastCheckedAt) {
                $heraRssCrawler = new HeraRssCrawler();
                $heraRssCrawler->setRetryCount(config('feed.crawler_retry_count'));

                try {
                    $rssFeed = $heraRssCrawler->parseFeed($feed->feed_url);

                    $numberOfNewUnreadFeedItems = $rssFeed->getFeedItems()->count();

                    if ($rssFeed instanceof RssFeed) {
                        $rssFeed->getFeedItems()->each(function (RssFeedItem $rssFeedItem) use ($user, $feed, $newLastCheckedAt) {
                            StoreRssFeedItem::dispatch($rssFeedItem, $user, $feed, $newLastCheckedAt);
                        });
                    } else {
                        Log::error('Couldn\'t parse feed "' . $feed->feed_url . '". Maybe it\'s not a valid XML file.');
                    }

                    $totalNumberOfNewUnreadFeedItemsForUser += $numberOfNewUnreadFeedItems;

                    $feedPrintOut = '  ' . $feed->title . ': ' . $numberOfNewUnreadFeedItems;

                    if ($numberOfNewUnreadFeedItems === 0) {
                        $this->line($feedPrintOut);
                    } else {
                        $this->info($feedPrintOut);
                    }

                    $feed->last_checked_at = $newLastCheckedAt;
                    $feed->save();
                } catch (ClientException $e) {
                    $this->error('Couldn\'t get feed "' . $feed->feed_url . '". It seems that the address isn\t reachable.');
                    Log::error($e, [$feed->feed_url]);
                } catch (Exception $e) {
                    $this->error('Couldn\'t parse feed "' . $feed->feed_url . '". Maybe it\'s not a valid XML file.');
                    Log::error($e, [$feed->feed_url]);
                }
            });

            $timeElapsedInSeconds = microtime(true) - $start;

            $updateLog = new UpdateLog();
            $updateLog->duration_in_seconds = (int) $timeElapsedInSeconds;
            $updateLog->save();

            $this->info('Total: ' . $totalNumberOfNewUnreadFeedItemsForUser . ' new items.');

            $this->info('');
            $this->line('-----');
            $this->info('');
        });

        Artisan::call(MarkKeywordFilteredFeedItems::class);
    }
}
