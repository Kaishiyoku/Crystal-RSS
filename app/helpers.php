<?php

const DATETIME = 'Y-m-d H:i';

if (! function_exists('getYearsFrom')) {
    function getYearsFrom($year)
    {
        return $year < date('Y') ? $year . '-' . date('Y') : date('Y');
    }
}

if (! function_exists('getUnreadFeedItemCountForCategory')) {
    function getUnreadFeedItemCountForCategory($category)
    {
        return $category->feeds()->get()->map(function ($feed) { return $feed->feedItems()->unread()->count(); })->sum();
    }
}