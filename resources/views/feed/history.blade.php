@extends('layouts.app')

@section('title', trans('feed.history.title'))

@section('content')
    <h1>
        {{ trans('feed.history.title') }}
        <small class="text-muted">{{ $totalCountReadFeedItems }}</small>
    </h1>

    @if ($readFeedItems->count() == 0)
        <p class="lead"><i>{{ trans('feed.history.no_items') }}</i></p>
    @else
        @include('feed._list', ['feedItems' => $readFeedItems])

        @include('shared._pagination', ['items' => $readFeedItems])
    @endif
@endsection