<?php

namespace App\Jobs;

use App\Models\FeedItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ProcessMarkFeedItemsAsHidden implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection<FeedItem>
     */
    private $feedItems;

    /**
     * Create a new job instance.
     *
     * @param Collection<FeedItem> $feedItems
     * @return void
     */
    public function __construct(Collection $feedItems)
    {
        $this->feedItems = $feedItems;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->feedItems->each(function (FeedItem $feedItem) {
            ProcessMarkFeedItemAsHidden::dispatch($feedItem, now());
        });
    }
}
