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
            Route::paginate('/categories/{id}', 'FeedController@category')->name('category');
            Route::paginate('/history', 'FeedController@history')->name('history');
            Route::put('/mark_all_as_read/{categoryId?}', 'FeedController@markAllAsRead')->name('mark_all_as_read');
            Route::put('/toggle_status/{id}', 'FeedController@toggleFeedItemStatus')->name('toggle_status');
            Route::get('/search', 'FeedController@searchShow')->name('search_show');
            Route::paginate('/search/results', 'FeedController@searchResult')->name('search_result');

            // Manage feed
            Route::resource('/manage', 'FeedManagerController', ['except' => 'show']);
        });

        // Categories
        Route::resource('/categories', 'CategoryController', ['except' => 'show']);
    });

    Auth::routes();
});