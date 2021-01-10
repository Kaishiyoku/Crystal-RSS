<?php

namespace App\Console\Commands;

use App\Models\FeedItem;
use Illuminate\Console\Command;

class ImportDataForSearchEngine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import existing database data to TNTSearch.';

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
        $this->info(__('feed.search.importing'));

        $this->call('scout:import', ['model' => FeedItem::class]);
    }
}
