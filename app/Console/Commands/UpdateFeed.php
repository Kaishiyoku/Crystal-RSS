<?php

namespace App\Console\Commands;

use App\Models\FeedItem;
use App\Models\UpdateError;
use App\Models\UpdateLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Kaishiyoku\HeraRssCrawler\HeraRssCrawler;
use PicoFeed\Config\Config;
use PicoFeed\PicoFeedException;
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
        $start = microtime(true);

        $this->info(__('feed.updating_at', ['date' => Carbon::now()]));
        $this->info(null);

        $config = new Config();
        $config->setClientTimeout(120);
        $config->setGrabberTimeout(120);

        $users = collect();

        if (empty($this->argument('user'))) {
            $users = User::active()->orderBy('name')->get();
        } else {
            $users->push(User::findOrFail($this->argument('user')));
        }

        $newLastCheckedAt = Carbon::now();

        foreach ($users as $user) {
            $totalNumberOfNewUnreadFeedItemsForUser = 0;

            $this->comment(__('feed.updating_feed_for_user', ['name' => $user->name]));
            $this->info(null);

            foreach ($user->enabledFeeds()->get() as $feed) {
                try {
                    $heraRssCrawler = new HeraRssCrawler();
                    $rssFeed = $heraRssCrawler->parseFeed($feed->feed_url);

                    $numberOfNewUnreadFeedItems = 0;

                    if ($rssFeed instanceof RssFeed) {
                        $rssFeed->getFeedItems()->map(function (RssFeedItem $item) use (&$user, &$numberOfNewUnreadFeedItems, $feed) {
                            if ($item->getChecksum() && $item->getPermalink() && $item->getCreatedAt()) {
                                try {
                                    $existingFeedItem = $user->feedItems()->whereFeedId($feed->id)->whereChecksum($item->getChecksum())->first();
                                    $newFeedItem = $existingFeedItem ?? new FeedItem();

                                    if ($existingFeedItem === null) {
                                        $newFeedItem->checksum = $item->getChecksum();

                                        $numberOfNewUnreadFeedItems++;
                                    }

                                    $newFeedItem->feed_id = $feed->id;
                                    $newFeedItem->url = $item->getPermalink();
                                    $newFeedItem->title = $item->getTitle();
                                    $newFeedItem->author = $item->getAuthors()->first();
                                    $newFeedItem->image_url = $item->getEnclosureUrl();
                                    $newFeedItem->posted_at = $item->getCreatedAt();
                                    $newFeedItem->content = $item->getContent();

                                    $newFeedItem->raw_json = $item->jsonSerialize();

                                    $user->feedItems()->save($newFeedItem);

                                    syncFeedItemCategories($item->getCategories(), $user, $newFeedItem);
                                } catch (QueryException $e) {
                                    $updateError = new UpdateError();
                                    $updateError->feed_id = $feed->id;
                                    $updateError->url = $item->getPermalink();
                                    $updateError->content = $e->getMessage();

                                    Log::error($e);

                                    $user->updateErrors()->save($updateError);
                                }
                            }
                        });
                    } else {
                        Log::error('Couldn\'t parse feed "' . $feed->feed_url . '". Maybe it\'s not a valid XML file.');
                    }

                    $totalNumberOfNewUnreadFeedItemsForUser = $totalNumberOfNewUnreadFeedItemsForUser + $numberOfNewUnreadFeedItems;

                    $feedPrintOut = '  ' . $feed->title . ': ' . $numberOfNewUnreadFeedItems;

                    if ($numberOfNewUnreadFeedItems == 0) {
                        $this->line($feedPrintOut);
                    } else {
                        $this->info($feedPrintOut);
                    }

                    $feed->last_checked_at = $newLastCheckedAt;
                    $feed->save();
                }
                catch (PicoFeedException $e) {
                    $this->error($e->getMessage());
                }
            }

            $timeElapsedInSeconds = microtime(true) - $start;

            $updateLog = new UpdateLog();
            $updateLog->duration_in_seconds = $timeElapsedInSeconds;
            $updateLog->save();

            $this->info('Total: ' . $totalNumberOfNewUnreadFeedItemsForUser . ' new items.');

            $this->info(null);
            $this->line('-----');
            $this->info(null);
        }
    }
}
