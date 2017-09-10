<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

class FeedController extends Controller
{
    public function unread()
    {
        $totalNumberOfUnreadFeedItems = auth()->user()->feedItems()->unread()->count();
        $unreadFeedItems = auth()->user()->feedItems()->unread()->with('feed')->take(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return response()->json([
            'totalNumberOfItems' => $totalNumberOfUnreadFeedItems,
            'items' => $unreadFeedItems->get()
        ]);
    }

    public function toggleFeedItemStatus(Request $request)
    {
        $feedItem = auth()->user()->feedItems()->findOrFail($request->get('id'));

        $feedItem->is_read = !$feedItem->is_read;
        $feedItem->save();

        return response()->json(['is_read' => $feedItem->is_read]);
    }
}