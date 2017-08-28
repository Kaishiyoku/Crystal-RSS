<?php

namespace App\Console\Commands;

use App\Models\FeedItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
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
        $ouputTableRows = [];

        foreach ($users as $user) {
            $this->comment(trans('feed.updating_feed_for_user', ['name' => $user->name]));
            $this->info(null);

            foreach ($user->feeds()->get() as $feed) {
                try {
                    $reader = new Reader($config);
                    $resource = $reader->download($feed->feed_url);
                    $parser = $reader->getParser($resource->getUrl(), $resource->getContent(), $resource->getEncoding());
                    $rssFeed = $parser->execute();
                    $newRssItems = array_filter($rssFeed->items, function ($item) use ($feed) {
                        $date = Carbon::instance($item->getDate());

                        return $date->gt($feed->last_checked_at) && $feed->feedItems()->where('url', '=', $item->getUrl())->count() == 0;
                    });

                    $ouputTableRows[] = [
                        $feed->title,
                        $feed->last_checked_at->format(DATETIME),
                        count($newRssItems)
                    ];

                    foreach ($newRssItems as $item) {
                        $feedItem = new FeedItem();
                        $feedItem->feed_id = $feed->id;
                        $feedItem->url = $item->getUrl();
                        $feedItem->title = $item->getTitle();
                        $feedItem->author = $item->getAuthor();
                        $feedItem->content = $item->getContent();
                        $feedItem->image_url = $item->getEnclosureUrl();
                        $feedItem->date = $item->getDate();

                        $user->feedItems()->save($feedItem);
                    }

                    $feed->last_checked_at = $newLastCheckedAt;
                    $feed->save();
                }
                catch (PicoFeedException $e) {
                    $this->error($e->getMessage());
                }
            }

            $this->table([trans('validation.attributes.title'), trans('validation.attributes.last_checked_at'), trans('feed.number_of_items')], $ouputTableRows);

            $this->info(null);
            $this->line('-----');
            $this->info(null);
        }
    }
}
