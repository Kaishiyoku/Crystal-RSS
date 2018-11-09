@extends('layouts.app')

@section('title', __('feed.index.title'))

@section('content')
    <h1>{{ __('feed.search_result.title') }}</h1>

    @include('feed._search_form')

    @if($foundFeedItemsFromIndex->count() == 0)
        <p class="lead font-italic">{{ __('feed.search_result.no_entries_found') }}</p>
    @endif

    <div class="mt-4">
        @include('shared._pagination', ['items' => $foundFeedItemsFromIndex])
    </div>

    @include('feed._list', ['feedItems' => $foundFeedItemsFromIndex, 'showActions' => false, 'categoryId' => null, 'hasAnotherPage' => false])

    <div class="mt-4">
        @include('shared._pagination', ['items' => $foundFeedItemsFromIndex])
    </div>
@endsection