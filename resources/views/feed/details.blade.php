@extends('layouts.app')

@section('title', __('feed.details.title', ['title' => $feedItem->id]))

@section('breadcrumbs')
    {!! Breadcrumbs::render('feed.details', $feedItem) !!}
@endsection

@section('content')
    <h1>
        @lang('feed.details.title', ['title' => $feedItem->id])
    </h1>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.id'):
        </div>

        <div>
            {{ $feedItem->id }}
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.feed_id'):
        </div>

        <div {!! $feedItem->feed->getStyle() !!}>
            {{ $feedItem->feed->title }}
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.url'):
        </div>

        <div>
            {{ Html::link($feedItem->url, null, ['class' => 'link']) }}
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.title'):
        </div>

        <div>
            {{ $feedItem->title }}
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.author'):
        </div>

        <div>
            {{ $feedItem->author ?? '/' }}
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.content'):
        </div>

        <div>
            {{ $feedItem->feedItemDetail->content }}
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.image_url'):
        </div>

        <div class="overflow-hidden">
            {{ Html::link($feedItem->image_url, null, ['class' => 'link']) }}
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.date'):
        </div>

        <div>
            {{ $feedItem->posted_at->format(l(DATETIME)) }}
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.checksum'):
        </div>

        <div class="overflow-auto py-2">
            <code>
                {{ $feedItem->checksum }}
            </code>
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.read_at'):
        </div>

        <div>
            @if ($feedItem->read_at)
                {{ $feedItem->read_at->format(l(DATETIME)) }}
            @else
                <i>@lang('feed.details.unread')</i>
            @endif
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('feed.categories'):
        </div>

        <div>
            @include('feed._categories', ['categories' => $feedItem->categories]):
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.vote_status'):
        </div>

        <div>
            <span
                data-provide="voter"
                data-vote-up-url="{{ route('feed.vote_up', $feedItem, false) }}"
                data-vote-down-url="{{ route('feed.vote_down', $feedItem, false) }}"
                data-vote-status="{{ $feedItem->vote_status }}"
            >
            </span>
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.favorited_at'):
        </div>

        <div>
            <span
                data-provide="favoriter"
                data-url="{{ route('feed.toggle_favorite', $feedItem, false) }}"
                data-favorited-at="{{ $feedItem->favorited_at }}"
            >
            </span>
        </div>
    </div>

    <div class="mb-3">
        <div class="font-bold text-xs text-gray-800 uppercase">
            @lang('validation.attributes.raw_json'):
        </div>

        <div>
            <pre class="prettyprint">{{ json_encode($feedItem->feedItemDetail->getJson(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    </div>

    @if ($feedItem->isDuplicate() || $feedItem->hasDuplicates())
        <hr class="mb-3"/>
    @endif

    @if ($feedItem->isDuplicate())
        <div class="mb-3">
            <div class="font-bold text-xs text-gray-800 uppercase">
                @lang('feed.duplicate_of'):
            </div>

            <div>
                @include('feed._duplicates_ist', ['feedItems' => collect([$feedItem->getFirstItemOfDuplicates()])])
            </div>
        </div>
    @endif

    @if ($feedItem->hasDuplicates())
        <div class="mb-3">
            <div class="font-bold text-xs text-gray-800 uppercase">
                @lang('feed.duplicates'):
            </div>

            <div>
                @include('feed._duplicates_ist', ['feedItems' => $feedItem->getDuplicates()])
            </div>
        </div>
    @endif
@endsection
