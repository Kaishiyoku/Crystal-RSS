<?php

namespace App\Console\Commands;

use App\Models\FeedItem;
use App\Models\UpdateError;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use PicoFeed\Config\Config;
use PicoFeed\PicoFeedException;
use PicoFeed\Reader\Reader;

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
    protected $description = 'Import existing database data to TNT search engine.';

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
        $this->info(trans('feed.search.importing'));

        $this->call('scout:import', ['model' => 'App\Models\FeedItem']);
    }
}