<?php


return [

    'update_interval' => env('UPDATE_INTERVAL', '30_MINUTES'),
    'crawler_retry_count' => env('CRAWLER_RETRY_COUNT', 0),
    'deferred_min_number' => env('DEFERRED_MIN_NUMBER', 1000),
    'deferred_mark_as_read' => env('DEFERRED_MARK_AS_READ', false),
    'deferred_per_page' => env('DEFERRED_PER_PAGE', 100),

];
