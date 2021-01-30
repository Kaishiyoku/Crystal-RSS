@extends('layouts.app')

@section('title', __('feed.index.title'))

@section('content')
    <h1>
        @lang('feed.search_result.title')

        <span class="headline-info">{{ $foundFeedItems->total() }}</span>
    </h1>

    <div class="mb-5">
        @include('feed._search_form')
    </div>

    @if ($foundFeedItems->count() == 0)
        <p class="text-lg italic">@lang('feed.search_result.no_entries_found')</p>
    @endif

    <div class="mt-4">
        {{ $foundFeedItems->links() }}
    </div>

    @include('feed._list', ['feedItems' => $foundFeedItems, 'showActions' => false, 'categoryId' => null, 'hasAnotherPage' => false])

    <div class="mt-4">
        {{ $foundFeedItems->links() }}
    </div>
@endsection
