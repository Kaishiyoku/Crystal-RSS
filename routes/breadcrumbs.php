<?php

// Manage feed
Breadcrumbs::register('feed.manage.index', function ($breadcrumbs) {
    $breadcrumbs->push(__('common.nav.manage_feed'), route('feed.manage.index'));
});

// Manage feed -> Create
Breadcrumbs::register('feed.manage.create', function ($breadcrumbs) {
    $breadcrumbs->parent('feed.manage.index');
    $breadcrumbs->push(__('feed_manager.create.title'));
});

// Manage feed -> Edit
Breadcrumbs::register('feed.manage.edit', function ($breadcrumbs, \App\Models\Feed $feed) {
    $breadcrumbs->parent('feed.manage.index');
    $breadcrumbs->push(__('feed_manager.edit.title', ['title' => $feed->title]));
});

// Manage categories
Breadcrumbs::register('categories.index', function ($breadcrumbs) {
    $breadcrumbs->push(__('common.nav.manage_categories'), route('categories.index'));
});

// Manage categories -> Create
Breadcrumbs::register('categories.create', function ($breadcrumbs) {
    $breadcrumbs->parent('categories.index');
    $breadcrumbs->push(__('category.create.title'));
});

// Manage categories -> Create
Breadcrumbs::register('categories.edit', function ($breadcrumbs, \App\Models\Category $category) {
    $breadcrumbs->parent('categories.index');
    $breadcrumbs->push(__('category.edit.title', ['title' => $category->title]));
});


// Feed
Breadcrumbs::register('feed.index', function ($breadcrumbs) {
    $breadcrumbs->push(__('common.nav.feed'), route('feed.index'));
});

// Feed -> Details
Breadcrumbs::register('feed.details', function ($breadcrumbs, \App\Models\FeedItem $feedItem) {
    $breadcrumbs->parent('feed.index');
    $breadcrumbs->push(__('feed.index.details'), route('feed.details', $feedItem));
});

// Update errors
Breadcrumbs::register('update_errors.index', function ($breadcrumbs) {
    $breadcrumbs->push(__('common.nav.update_errors'), route('update_errors.index'));
});

// Update errors -> Details
Breadcrumbs::register('update_errors.show', function ($breadcrumbs) {
    $breadcrumbs->parent('update_errors.index');
    $breadcrumbs->push(__('common.details'));
});