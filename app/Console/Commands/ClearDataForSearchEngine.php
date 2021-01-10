<?php

namespace App\Console\Commands;

use App\Models\FeedItem;
use Illuminate\Console\Command;

class ClearDataForSearchEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all TNTSearch records.';

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
        $this->info(__('feed.search.clearing'));

        $this->call('scout:flush', ['model' => FeedItem::class]);
    }
}
