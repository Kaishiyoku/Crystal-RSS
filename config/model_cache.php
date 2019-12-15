<?php

return [

    'statistics' => [
        'feed_items' => [
            'prefix' => 'statistic_feed_items',
            'duration' => env('MODEL_CACHE_STATISTICS_FEED_ITEMS_DURATION', 60 * 60 * 2), // default: 2 hours
        ],
    ],

];
