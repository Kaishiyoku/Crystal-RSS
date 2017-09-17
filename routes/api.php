<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->as('api.')->group(function () {
    Route::post('/login', 'Auth\LoginController@login')->name('auth.login');
    Route::post('/register', 'Auth\RegisterController@register')->name('auth.register');
});

Route::middleware('auth:api')->as('api.')->group(function () {
    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });

    Route::get('/feed/unread', 'Api\FeedController@unread')->name('feed.unread');
    Route::get('/feed/read', 'Api\FeedController@read')->name('feed.read');
    Route::put('/feed/toggle_status', 'Api\FeedController@toggleFeedItemStatus')->name('feed.toggle_status');
    Route::put('/feed/mark_all_as_read', 'Api\FeedController@markAllAsRead')->name('feed.mark_all_as_read');

    Route::put('/store/update', 'Api\StoreController@update')->name('store.update');
    Route::get('/store/retrieve', 'Api\StoreController@retrieve')->name('store.retrieve');
    Route::delete('/store/clear', 'Api\StoreController@clear')->name('store.clear');

    Route::resource('/feed/manage', 'Api\FeedManagerController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
    Route::resource('/categories', 'Api\CategoryController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
});