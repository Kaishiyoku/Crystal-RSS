<?php

// Manage feed
Breadcrumbs::register('feed.manage.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('common.nav.manage_feed'), route('feed.manage.index'));
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

// Manage categories
Breadcrumbs::register('categories.index', function ($breadcrumbs) {
    $breadcrumbs->push(trans('common.nav.manage_categories'), route('categories.index'));
});

// Manage categories -> Create
Breadcrumbs::register('categories.create', function ($breadcrumbs) {
    $breadcrumbs->parent('categories.index');
    $breadcrumbs->push(trans('category.create.title'));
});

// Manage categories -> Create
Breadcrumbs::register('categories.edit', function ($breadcrumbs, \App\Models\Category $category) {
    $breadcrumbs->parent('categories.index');
    $breadcrumbs->push(trans('category.edit.title', ['title' => $category->title]));
});