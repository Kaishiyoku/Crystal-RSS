<?php

namespace App\Console\Commands;

use App\Models\Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Kaishiyoku\HeraRssCrawler\HeraRssCrawler;

class CheckFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if feeds are valid';

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
        $heraRssCrawler = new HeraRssCrawler();
        $feeds = Feed::all();

        $feeds->each(function (Feed $feed) use ($heraRssCrawler) {
            $isValid = $heraRssCrawler->checkIfConsumableFeed($feed->feed_url);

            $feed->is_valid = $isValid;
            $feed->save();

            $this->output->write('Checking feed "' . $feed->feed_url . '": ', false);
            $this->output->write($isValid ? 'valid' : 'invalid', true);

            if (!$isValid) {
                Log::error('Feed invalid: ' . $feed->feed_url);
            }
        });
    }
}
