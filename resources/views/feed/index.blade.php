@extends('layouts.app')

@section('title', trans('feed.index.title'))

@section('content')
    <h1>
        {{ trans('feed.index.title') }}
        <small class="text-muted">{{ $totalCountUnreadFeedItems }}</small>
    </h1>

    <p>
        {{ Form::open(['route' => 'feed.update_feed', 'method' => 'put', 'role' => 'form', 'class' => 'd-inline']) }}
            {{ Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> ' . trans('feed.index.update_feed'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
        {{ Form::close() }}

        @if ($unreadFeedItems->count() > 0)
            {{ Form::open(['route' => 'feed.mark_all_as_read', 'method' => 'put', 'role' => 'form', 'class' => 'd-inline']) }}
                {{ Form::button('<i class="fa fa-eye" aria-hidden="true"></i> ' . trans('feed.index.mark_all_as_read'), ['type' => 'submit', 'class' => 'btn btn-secondary', 'data-confirm' => true]) }}
            {{ Form::close() }}
        @endif
    </p>

    @if ($unreadFeedItems->count() == 0)
        <p class="lead"><i>{{ trans('feed.index.no_unread_items') }}</i></p>
    @else
        @include('shared._feed_item_list', ['feedItems' => $unreadFeedItems, 'showActions' => true])

        @include('shared._pagination', ['items' => $unreadFeedItems])
    @endif
@endsection