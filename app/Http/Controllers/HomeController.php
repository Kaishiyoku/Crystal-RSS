<?php

namespace App\Http\Controllers;

use Vinelab\Rss\Rss;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('feed.index');
        }

        return view('home.welcome');
    }
}
