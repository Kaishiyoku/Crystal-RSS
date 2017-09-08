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

Route::post('/api/login', 'Api\AuthController@login')->name('api.auth.login');

Route::middleware('auth:api')->as('api.')->group(function () {
    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });

    Route::get('/feed/unread', 'Api\FeedController@unread')->name('feed.unread');
});