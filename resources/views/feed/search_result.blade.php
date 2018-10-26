@extends('layouts.app')

@section('title', trans('feed.index.title'))

@section('content')
    <h1>{{ trans('feed.search_result.title') }}</h1>

    @include('feed._search_form')

    @if($foundFeedItemsFromIndex->count() == 0)
        <p class="lead font-italic">{{ trans('feed.search_result.no_entries_found') }}</p>
    @endif

    <div class="mt-4">
        {{ $foundFeedItemsFromIndex->links('vendor.pagination.bootstrap-4') }}
    </div>

    @include('feed._list', ['feedItems' => $foundFeedItemsFromIndex, 'showActions' => false, 'categoryId' => null, 'hasAnotherPage' => false])

    <div class="mt-4">
        {{ $foundFeedItemsFromIndex->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection