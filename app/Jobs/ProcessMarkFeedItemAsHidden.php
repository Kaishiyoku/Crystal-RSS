<?php

namespace App\Jobs;

use App\Models\FeedItem;
use Carbon\Carbon;
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
     * @var Carbon
     */
    protected $date;

    /**
     * Create a new job instance.
     *
     * @param FeedItem $feedItem
     * @param Carbon $date
     * @return void
     */
    public function __construct(FeedItem $feedItem, Carbon $date)
    {
        $this->feedItem = $feedItem;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->feedItem->hidden_at = $this->date;

        $this->feedItem->save();
    }
}
