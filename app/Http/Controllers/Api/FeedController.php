<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

class FeedController extends Controller
{
    public function unread()
    {
        //$unreadFeedItems = auth()->user()->feedItems()->unread();

        //return response()->json($unreadFeedItems->get());

        return response()->json([]);
    }
}