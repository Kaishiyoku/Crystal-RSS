<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function unread()
    {
        $unreadFeedItems = $this->getFeedItems()->unread();

        return response()->json($unreadFeedItems->get());
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

    public function read()
    {
        $readFeedItems = $this->getFeedItems()->read();

        return response()->json($readFeedItems->get());
    }

    private function getFeedItems()
    {
        return auth()->user()->feedItems()->select('id', 'user_id', 'feed_id', 'is_read', 'url', 'title', 'author', 'date')->with(['feed' => function ($query) {
            $query->select('id', 'title');
        }]);
    }
}