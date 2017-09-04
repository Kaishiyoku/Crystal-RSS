<?php
    $showActions = isset($showActions) ? $showActions : false;
    $categoryId = isset($categoryId) ? $categoryId : null;
    $hasAnotherPage = isset($hasAnotherPage) ? $hasAnotherPage : false;
?>

<ul class="list-group" data-load-more="{{ URL::route('feed.more_unread', [env('NUMBER_OF_ITEMS_PER_PAGE'), $categoryId]) }}" data-button="#load-more">
    @foreach ($feedItems as $feedItem)
        @include('feed._item', ['feedItem' => $feedItem, 'showActions' => $showActions])
    @endforeach
</ul>

@if ($hasAnotherPage)
    <p class="mt-3 justify-content-center">
        <button type="button" id="load-more" class="btn btn-outline-primary">{{ trans('common.load_more') }}</button>
    </p>
@endif