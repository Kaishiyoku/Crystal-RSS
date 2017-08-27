<?php

Route::group(['middleware' => ['menus']], function () {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/login', 'HomeController@login')->name('home.login');

    /* ****************
     * Logged on users *
     **************** */
    Route::group(['middleware' => ['auth']], function () {
        Route::resource('manage_feeds', 'FeedManagerController', ['except' => 'show']);
        Route::put('update_feeds', 'HomeController@updateFeeds')->name('home.update_feeds');
        Route::put('mark_feed_item_as_read/{id}', 'HomeController@markFeedItemAsRead')->name('home.mark_feed_item_as_read');
        Route::get('history', 'HomeController@history')->name('home.history');
    });

    Auth::routes();
});