<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

class FeedController extends Controller
{
    public function unread()
    {
        $totalNumberOfUnreadFeedItems = $this->getUnreadFeedItems()->count();
        $unreadFeedItems = $this->getUnreadFeedItems()->take(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return response()->json([
            'totalNumberOfItems' => $totalNumberOfUnreadFeedItems,
            'hasAnotherPage' => env('NUMBER_OF_ITEMS_PER_PAGE') < $totalNumberOfUnreadFeedItems,
            'nextOffset' => env('NUMBER_OF_ITEMS_PER_PAGE'),
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

    public function moreUnread($offset = null, $categoryId = null)
    {
        $unreadFeedItems = $this->getUnreadFeedItems($categoryId);
        $totalCount = $unreadFeedItems->count();

        if ($offset) {
            $unreadFeedItems = $unreadFeedItems->skip($offset);
        }

        $unreadFeedItems = $unreadFeedItems->take(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return response()->json([
            'hasAnotherPage' => $offset + env('NUMBER_OF_ITEMS_PER_PAGE') < $totalCount,
            'nextOffset' => $offset + env('NUMBER_OF_ITEMS_PER_PAGE'),
            'items' => $unreadFeedItems->get()
        ]);
    }

    private function getUnreadFeedItems()
    {
        return auth()->user()->feedItems()->unread()->with('feed');
    }
}