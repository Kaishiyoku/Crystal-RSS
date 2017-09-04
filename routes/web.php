<?php

Route::group(['middleware' => ['menus']], function () {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/login', 'HomeController@login')->name('home.login');

    /* ****************
     * Logged on users *
     **************** */
    Route::group(['middleware' => ['auth']], function () {
        // Feed
        Route::prefix('feed')->as('feed.')->group(function () {
            Route::paginate('/', 'FeedController@index')->name('index');
            Route::get('/more_unread/{offset?}/{categoryId?}', 'FeedController@moreUnread')->name('more_unread');
            Route::paginate('/categories/{id}', 'FeedController@category')->name('category');
            Route::paginate('/history', 'FeedController@history')->name('history');
            Route::put('/update', 'FeedController@updateFeed')->name('update_feed');
            Route::put('/mark_all_as_read/{categoryId?}', 'FeedController@markAllAsRead')->name('mark_all_as_read');
            Route::put('/toggle_status/{id}', 'FeedController@toggleFeedItemStatus')->name('toggle_status');

            // Manage feed
            Route::resource('/manage', 'FeedManagerController', ['except' => 'show']);
        });

        // Categories
        Route::resource('/categories', 'CategoryController', ['except' => 'show']);
    });

    Auth::routes();
});