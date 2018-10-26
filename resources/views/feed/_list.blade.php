<?php
    $showActions = isset($showActions) ? $showActions : false;
    $categoryId = isset($categoryId) ? $categoryId : null;
    $hasAnotherPage = isset($hasAnotherPage) ? $hasAnotherPage : false;
?>

<ul class="list-group">
    @foreach ($feedItems as $feedItem)
        @include('feed._item', ['feedItem' => $feedItem, 'showActions' => $showActions])
    @endforeach
</ul>