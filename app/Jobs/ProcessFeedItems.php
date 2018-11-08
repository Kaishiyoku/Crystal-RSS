<?php

namespace App\Jobs;

use App\Models\FeedItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ProcessFeedItems implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $feedItems;
    protected $date;

    /**
     * Create a new job instance.
     *
     * @param  Collection  $feedItems
     * @param  Carbon  $date
     */
    public function __construct(Collection $feedItems, Carbon $date)
    {
        $this->feedItems = $feedItems;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->feedItems as $feedItem) {
            $feedItem->read_at = $this->date;

            $feedItem->save();
        }
    }
}
