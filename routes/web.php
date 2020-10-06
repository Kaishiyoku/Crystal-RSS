<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FeedManagerController;
use App\Http\Controllers\FilterKeywordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UpdateErrorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/imprint', [HomeController::class, 'imprint'])->name('home.imprint');
Route::get('/contact', [HomeController::class, 'showContactForm'])->name('home.contact');
Route::post('/contact', [HomeController::class, 'sendContactForm'])->name('home.contact_send');
Route::get('/login', [HomeController::class, 'login'])->name('home.login');
Route::post('/lang/change', [LanguageController::class, 'change'])->name('language.change');

/* *****************
 * Logged on users *
 ***************** */
Route::group(['middleware' => ['auth']], function () {
    // Feed
    Route::prefix('feed')->as('feed.')->group(function () {
        Route::get('/', [FeedController::class, 'index'])->name('index');
        Route::get('/categories/{id}', [FeedController::class, 'category'])->name('category');
        Route::get('/history', [FeedController::class, 'history'])->name('history');
        Route::put('/mark_all_as_read/{categoryId?}', [FeedController::class, 'markAllAsRead'])->name('mark_all_as_read');
        Route::put('/toggle_status/', [FeedController::class, 'toggleFeedItemStatus'])->name('toggle_status');
        Route::get('/search', [FeedController::class, 'searchShow'])->name('search_show');
        Route::get('/search/results', [FeedController::class, 'searchResult'])->name('search_result');

        Route::put('/{feedItem}/vote_up', [FeedController::class, 'voteUp'])->name('vote_up');
        Route::put('/{feedItem}/vote_down', [FeedController::class, 'voteDown'])->name('vote_down');

        Route::put('/{feedItem}/toggle_favorite', [FeedController::class, 'toggleFavorite'])->name('toggle_favorite');

        // Manage feed
        Route::get('/manage/archived', [FeedManagerController::class, 'archived'])->name('manage.archived');
        Route::post('/manage/discover', [FeedManagerController::class, 'discover'])->name('manage.discover');
        Route::put('/manage/archived/{feed}/restore', [FeedManagerController::class, 'restore'])->name('manage.restore');
        Route::delete('/manage/archived/{feed}', [FeedManagerController::class, 'destroyPermanently'])->name('manage.destroy_permanently');
        Route::resource('/manage', FeedManagerController::class, ['except' => 'show'])->parameters([
            'manage' => 'feed',
        ]);
    });

    // Categories
    Route::resource('/categories', CategoryController::class, ['except' => 'show']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/email/edit', [ProfileController::class, 'editEmail'])->name('profile.edit_email');
    Route::put('/profile/email/edit', [ProfileController::class, 'updateEmail'])->name('profile.update_email');
    Route::get('/profile/email/confirm/{token}', [ProfileController::class, 'confirmNewEmail'])->name('profile.confirm_new_email');
    Route::get('/profile/password/change', [ProfileController::class, 'editPassword'])->name('profile.edit_password');
    Route::put('/profile/password/change', [ProfileController::class, 'updatePassword'])->name('profile.update_password');
    Route::get('/profile/settings/edit', [ProfileController::class, 'editSettings'])->name('profile.edit_settings');
    Route::put('/profile/settings/edit', [ProfileController::class, 'updateSettings'])->name('profile.update_settings');

    // Statistics
    Route::get('/statistics/{startingYear?}/{startingMonth?}', [StatisticController::class, 'index'])->name('statistics.index');

    // FilterKeywords
    Route::resource('/filter_keywords', FilterKeywordController::class);

    /* ****************
     * Administrators *
     **************** */
    Route::group(['middleware' => ['admin']], function () {
        // Feed
        Route::get('/feed/{feedItem}/details', [FeedController::class, 'details'])->name('feed.details');

        // UpdateError
        Route::delete('/update_errors', [UpdateErrorController::class, 'clear'])->name('update_errors.clear');
        Route::resource('update_errors', UpdateErrorController::class)->only(['index', 'show']);
    });
});

Auth::routes();
