<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ClearUserSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:clear_settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all user settings.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        $users->each(function (User $user) {
            $user->settings()->clear();
        });
    }
}
