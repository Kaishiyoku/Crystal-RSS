@extends('layouts.app')

@section('title', trans('home.history.title'))

@section('content')
    <h1>{{ trans('home.history.title') }}</h1>

    <h2 class="pt-4">{{ trans('home.history.read') }}</h2>

    @if ($readFeedItems->count() == 0)
        <p class="lead"><i>{{ trans('home.history.no_items') }}</i></p>
    @else
        @include('shared._feed_item_list', ['feedItems' => $readFeedItems->get()])
    @endif
@endsection