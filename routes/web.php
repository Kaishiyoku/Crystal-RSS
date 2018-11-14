<?php

Route::group(['middleware' => ['menus']], function () {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/login', 'HomeController@login')->name('home.login');
    Route::post('/lang/change', 'LanguageController@change')->name('language.change');

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
            Route::put('/toggle_status/', 'FeedController@toggleFeedItemStatus')->name('toggle_status');
            Route::get('/search', 'FeedController@searchShow')->name('search_show');
            Route::paginate('/search/results', 'FeedController@searchResult')->name('search_result');

            // Manage feed
            Route::resource('/manage', 'FeedManagerController', ['except' => 'show']);
        });

        // Categories
        Route::resource('/categories', 'CategoryController', ['except' => 'show']);

        // Profile
        Route::get('/profile', 'ProfileController@index')->name('profile.index');
        Route::get('/profile/email/edit', 'ProfileController@editEmail')->name('profile.edit_email');
        Route::put('/profile/email/edit', 'ProfileController@updateEmail')->name('profile.update_email');
        Route::get('/profile/email/confirm/{token}', 'ProfileController@confirmNewEmail')->name('profile.confirm_new_email');
        Route::get('/profile/password/change', 'ProfileController@editPassword')->name('profile.edit_password');
        Route::put('/profile/password/change', 'ProfileController@updatePassword')->name('profile.update_password');
    });

    Auth::routes();
});