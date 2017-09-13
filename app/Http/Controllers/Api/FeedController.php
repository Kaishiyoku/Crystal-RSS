<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function unread()
    {
        $unreadFeedItems = auth()->user()->feedItems()->unread()->with('feed');

        return response()->json([
            'items' => $unreadFeedItems->get()
        ]);
    }

    public function toggleFeedItemStatus(Request $request)
    {
        $feedItem = auth()->user()->feedItems()->findOrFail($request->get('id'));

        $feedItem->is_read = !$feedItem->is_read;
        $feedItem->save();

        return response()->json(['isRead' => $feedItem->is_read]);
    }

    public function markAllAsRead()
    {
        auth()->user()->feedItems()->unread()->update(['is_read' => true]);

        return response()->json();
    }
}