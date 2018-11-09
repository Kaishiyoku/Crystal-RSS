@extends('layouts.app')

@section('title', __('feed.history.title'))

@section('content')
    <h1>
        {{ __('feed.history.title') }}
        <small class="text-muted">{{ $totalCountReadFeedItems }}</small>
    </h1>

    @if ($readFeedItems->count() == 0)
        <p class="lead"><i>{{ __('feed.history.no_items') }}</i></p>
    @else
        @include('feed._list', ['feedItems' => $readFeedItems])

        @include('shared._pagination', ['items' => $readFeedItems])
    @endif
@endsection