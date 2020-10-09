<?php

namespace App\Console\Commands;

use App\Jobs\ProcessMarkFeedItemsAsUnhidden;
use App\Models\User;
use Illuminate\Console\Command;

class MarkKeywordFilteredFeedItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:mark-keyword-filtered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark keyword-filtered feed items';

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
     * @return int
     */
    public function handle()
    {
        $this->line('Marking feed items matching set keywords as hidden...');
        $this->line('');

        $users = User::all();

        $users->each(function (User $user) {
            $numberOfFeedItems = markFeedItemsAsHiddenByKeywords($user);

            $this->line('  ' . $user->name . ': ' . $numberOfFeedItems);
        });

        return 0;
    }
}
