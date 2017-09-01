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
        return auth()->check() ? $this->indexAuth() : $this->indexGuest();
    }

    private function indexGuest()
    {
        return view('home.index');
    }

    private function indexAuth()
    {
        $totalCountUnreadFeedItems = auth()->user()->feedItems()->unread()->count();
        $unreadFeedItems = auth()->user()->feedItems()->unread()->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return view('feed.index', compact('totalCountUnreadFeedItems', 'unreadFeedItems'));
    }
}