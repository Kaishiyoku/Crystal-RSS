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

    public function updateFeeds()
    {
        $exitCode = Artisan::call('feeds:update', [
            'user' => auth()->user()->id
        ]);

        flash()->success(trans('home.update_feeds.success'));

        return redirect()->to('/');
    }

    public function markFeedItemAsRead($id)
    {
        $feedItem = auth()->user()->feedItems()->findOrFail($id);

        $feedItem->is_read = true;
        $feedItem->save();

        return response()->json();
    }
}