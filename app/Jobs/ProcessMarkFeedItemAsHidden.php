<?php

namespace App\Jobs;

use App\Models\FeedItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMarkFeedItemAsHidden implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var FeedItem
     */
    protected $feedItem;

    /**
     * Create a new job instance.
     *
     * @param FeedItem $feedItem
     * @return void
     */
    public function __construct(FeedItem $feedItem)
    {
        $this->feedItem = $feedItem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->feedItem->hidden_at) {
            return;
        }

        $this->feedItem->hidden_at = now();

        $this->feedItem->save();
    }
}
