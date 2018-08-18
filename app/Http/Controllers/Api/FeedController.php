<?php

namespace App\Http\Controllers\Api;

use App\Models\FeedItem;
use Carbon\Carbon;
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

        if ($feedItem->is_read) {
            $feedItem->read_at = Carbon::now();
        } else {
            $feedItem->read_at = null;
        }

        $feedItem->save();

        return response()->json(['isRead' => $feedItem->is_read]);
    }

    public function markAllAsRead()
    {
        auth()->user()->feedItems()->unread()->update(['is_read' => true, 'read_at' => Carbon::now()]);

        return response()->json();
    }

    public function read()
    {
        $readFeedItems = $this->getFeedItems()->read();

        return response()->json($readFeedItems->get());
    }

    public function search($term)
    {
        $foundFeedItemsFromIndex = FeedItem::search($term)->where('user_id', auth()->user()->id);
        $ids = $foundFeedItemsFromIndex->get()->pluck('id');

        return response()->json($this->getFeedItems()->find($ids));
    }

    private $feedItemColumns = ['id', 'feed_id', 'is_read', 'url', 'title', 'date'];

    private function getFeedItems()
    {
        return auth()->user()->feedItems()->select($this->feedItemColumns)->with(['feed' => function ($query) {
            $query->select('id', 'title');
        }]);
    }
}