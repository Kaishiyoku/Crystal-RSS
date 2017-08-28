<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use PicoFeed\PicoFeedException;
use PicoFeed\Reader\Reader;
use Vinelab\Rss\Rss;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        if (auth()->check()) {
            $unreadFeedItems = auth()->user()->feedItems()->unread();

            $data = compact('unreadFeedItems');
        }

        return view('home.index', $data);
    }

    public function history()
    {
        $readFeedItems = auth()->user()->feedItems()->read();
        $unreadFeedItems = auth()->user()->feedItems()->unread();

        return view('home.history', compact('readFeedItems', 'unreadFeedItems'));
    }

    public function updateFeeds()
    {
        $exitCode = Artisan::call('feeds:update', [
            'user' => auth()->user()->id
        ]);

        flash()->success(trans('home.update_feeds.success'));

        return redirect()->to('/');
    }

    public function markAllAsRead()
    {
        $unreadFeedItems = auth()->user()->feedItems()->unread();

        foreach ($unreadFeedItems->get() as $unreadFeedItem) {
            $unreadFeedItem->is_read = true;

            $unreadFeedItem->save();
        }

        flash()->success(trans('home.mark_all_as_read.success'));

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