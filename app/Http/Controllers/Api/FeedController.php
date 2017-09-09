<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

class FeedController extends Controller
{
    public function unread()
    {
        $unreadFeedItems = auth()->user()->feedItems()->unread()->take(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return response()->json($unreadFeedItems->get());
    }
}