<?php

namespace App\Console\Commands;

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
    protected $description = 'Import existing database data to MySQL FULLTEXT.';

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

        $this->call('scout:mysql-index', ['model' => 'App\Models\FeedItem']);
    }
}
