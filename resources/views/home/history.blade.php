@extends('layouts.app')

@section('title', trans('home.history.title'))

@section('content')
    <h1>{{ trans('home.history.title') }}</h1>

    @if ($unreadFeedItems->count() > 0)
        <h2>{{ trans('home.history.unread') }}</h2>

        <p>
            {{ Form::open(['route' => 'home.mark_all_as_read', 'method' => 'put', 'role' => 'form', 'class' => 'd-inline']) }}
                {{ Form::button('<i class="fa fa-eye" aria-hidden="true"></i> ' . trans('home.index.mark_all_as_read'), ['type' => 'submit', 'class' => 'btn btn-secondary', 'data-confirm' => true]) }}
            {{ Form::close() }}
        </p>

        @include('shared._feed_item_list', ['feedItems' => $unreadFeedItems->get(), 'showActions' => true])
    @endif

    <h2 class="pt-4">{{ trans('home.history.read') }}</h2>

    @if ($readFeedItems->count() == 0)
        <p class="lead"><i>{{ trans('home.history.no_items') }}</i></p>
    @else
        @include('shared._feed_item_list', ['feedItems' => $readFeedItems->get()])
    @endif
@endsection