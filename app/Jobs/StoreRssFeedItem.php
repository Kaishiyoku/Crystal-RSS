<?php

namespace App\Jobs;

use App\Models\Feed;
use App\Models\FeedItem;
use App\Models\UpdateError;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Kaishiyoku\HeraRssCrawler\Models\Rss\FeedItem as RssFeedItem;

class StoreRssFeedItem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var RssFeedItem
     */
    protected $rssFeedItem;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Feed
     */
    protected $feed;

    /**
     * @var Carbon
     */
    protected $newLastCheckedAt;

    /**
     * Create a new job instance.
     *
     * @param RssFeedItem $rssFeedItem
     * @param User $user
     * @param Feed $feed
     * @param Carbon $newLastCheckedAt
     * @return void
     */
    public function __construct(RssFeedItem $rssFeedItem, User $user, Feed $feed, Carbon $newLastCheckedAt)
    {
        $this->rssFeedItem = $rssFeedItem;
        $this->user = $user;
        $this->feed = $feed;
        $this->newLastCheckedAt = $newLastCheckedAt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->rssFeedItem->getChecksum() && $this->rssFeedItem->getPermalink() && $this->rssFeedItem->getCreatedAt()) {
            try {
                $existingFeedItem = $this->user->feedItems()->whereFeedId($this->feed->id)->whereChecksum($this->rssFeedItem->getChecksum())->first();
                $newFeedItem = $existingFeedItem ?? new FeedItem();

                if ($existingFeedItem === null) {
                    $newFeedItem->checksum = $this->rssFeedItem->getChecksum();
                }

                $newFeedItem->feed_id = $this->feed->id;
                $newFeedItem->url = $this->rssFeedItem->getPermalink();
                $newFeedItem->title = $this->rssFeedItem->getTitle();
                $newFeedItem->author = $this->rssFeedItem->getAuthors()->first();
                $newFeedItem->image_url = $this->rssFeedItem->getEnclosureUrl();
                $newFeedItem->posted_at = $this->rssFeedItem->getCreatedAt();
                $newFeedItem->content = $this->rssFeedItem->getContent();

                $newFeedItem->raw_json = $this->rssFeedItem->jsonSerialize();

                $this->user->feedItems()->save($newFeedItem);

                if ($this->user->settings()->get('feed_items.mark_duplicates_as_read_automatically')
                    && ($newFeedItem->isDuplicate() || $newFeedItem->hasDuplicates())) {
                    $newFeedItem->read_at = $this->newLastCheckedAt;
                    $newFeedItem->save();
                }

                syncFeedItemCategories($this->rssFeedItem->getCategories(), $this->user, $newFeedItem);
            } catch (QueryException $e) {
                $updateError = new UpdateError();
                $updateError->feed_id = $this->feed->id;
                $updateError->url = $this->rssFeedItem->getPermalink();
                $updateError->content = $e->getMessage();

                Log::error($e);

                $this->user->updateErrors()->save($updateError);
            }
        }
    }
}
