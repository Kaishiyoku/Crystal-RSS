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
        Route::put('mark_all_as_read', 'HomeController@markAllAsRead')->name('home.mark_all_as_read');
        Route::put('toggle_status/{id}', 'HomeController@toggleFeedItemStatus')->name('home.toggle_status');
        Route::get('history', 'HomeController@history')->name('home.history');
    });

    Auth::routes();
});