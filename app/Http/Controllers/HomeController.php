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
        $unreadFeedItems = auth()->user()->feedItems()->unread();

        return view('feed.index', compact('unreadFeedItems'));
    }
}