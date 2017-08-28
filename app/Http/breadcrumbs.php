<?php

// Manage feed
Breadcrumbs::register('feed.manage.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('common.nav.manage_feeds'), route('feed.manage.index'));
});

// Manage feed -> Create
Breadcrumbs::register('feed.manage.create', function ($breadcrumbs) {
    $breadcrumbs->parent('feed.manage.index');
    $breadcrumbs->push(trans('feed_manager.create.title'));
});

// Manage feed -> Edit
Breadcrumbs::register('feed.manage.edit', function ($breadcrumbs, \App\Models\Feed $feed) {
    $breadcrumbs->parent('feed.manage.index');
    $breadcrumbs->push(trans('feed_manager.edit.title', ['title' => $feed->title]));
});