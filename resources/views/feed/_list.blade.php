<?php
    $showActions = isset($showActions) ? $showActions : false;
    $categoryId = isset($categoryId) ? $categoryId : null;
    $hasAnotherPage = isset($hasAnotherPage) ? $hasAnotherPage : false;
?>

@if ($showActions)
    {{ Form::open(['route' => ['feed.toggle_status'], 'method' => 'put', 'role' => 'form']) }}
@endif

<div class="card my-5">
    @foreach ($feedItems as $feedItem)
        @include('feed._item', ['feedItem' => $feedItem, 'showActions' => $showActions])
    @endforeach
</div>

@if ($showActions)
    <p class="mt-2">
        {{ Form::button('<i class="fas fa-eye"></i> ' . __('feed.index.toggle_status.submit'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-confirm' => true]) }}
    </p>

    {{ Form::close() }}
@endif
