<?php

namespace App\Console\Commands;

use App\Models\FeedItem;
use App\Models\FeedItemCategory;
use App\Models\UpdateError;
use App\Models\UpdateLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PicoFeed\Config\Config;
use PicoFeed\PicoFeedException;
use PicoFeed\Reader\Reader;

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
                    $reader = new Reader($config);
                    $resource = $reader->discover($feed->feed_url);
                    $parser = $reader->getParser($resource->getUrl(), $resource->getContent(), $resource->getEncoding());
                    $rssFeed = $parser->execute();

                    $numberOfNewUnreadFeedItems = 0;

                    foreach ($rssFeed->getItems() as $item) {
                        if ($item->getId() && $item->getUrl()) {
                            try {
                                $existingFeedItem = FeedItem::whereFeedId($feed->id)->whereChecksum($item->getId())->first();
                                $newFeedItem = $existingFeedItem == null ? new FeedItem() : $existingFeedItem;

                                if ($existingFeedItem == null) {
                                    $newFeedItem->checksum = $item->getId();

                                    $numberOfNewUnreadFeedItems++;
                                }

                                $newFeedItem->feed_id = $feed->id;
                                $newFeedItem->url = $item->getUrl();
                                $newFeedItem->title = $item->getTitle();
                                $newFeedItem->author = $item->getAuthor();
                                $newFeedItem->image_url = $item->getEnclosureUrl();
                                $newFeedItem->date = $item->getDate();
                                $newFeedItem->content = $item->getContent();

                                $jsonDataList = collect(array_filter(json_decode(json_encode($item->getXml()), true)));
                                $jsonDataList = $jsonDataList->filter(function ($item, $key) {
                                    return $key != 'category';
                                });
                                $newFeedItem->raw_json = json_encode($jsonDataList->toArray());

                                $user->feedItems()->save($newFeedItem);

                                syncFeedItemCategories($item->getCategories(), $user, $newFeedItem);
                            } catch (QueryException $e) {
                                $updateError = new UpdateError();
                                $updateError->feed_id = $feed->id;
                                $updateError->content = "Error parsing {$item->getUrl()}";

                                Log::error($e);

                                $user->updateErrors()->save($updateError);
                            }
                        }
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