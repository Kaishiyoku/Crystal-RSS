<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class FeedController extends Controller
{
    public function history()
    {
        $readFeedItems = auth()->user()->feedItems()->read();

        return view('feed.history', compact('readFeedItems'));
    }

    public function updateFeed()
    {
        $exitCode = Artisan::call('feeds:update', [
            'user' => auth()->user()->id
        ]);

        flash()->success(trans('feed.update_feed.success'));

        return redirect()->to('/');
    }

    public function markAllAsRead()
    {
        $unreadFeedItems = auth()->user()->feedItems()->unread();

        foreach ($unreadFeedItems->get() as $unreadFeedItem) {
            $unreadFeedItem->is_read = true;

            $unreadFeedItem->save();
        }

        flash()->success(trans('feed.mark_all_as_read.success'));

        return redirect()->back();
    }

    public function toggleFeedItemStatus($id)
    {
        $feedItem = auth()->user()->feedItems()->findOrFail($id);

        $feedItem->is_read = !$feedItem->is_read;
        $feedItem->save();

        return response()->json(['isRead' => $feedItem->is_read]);
    }
}