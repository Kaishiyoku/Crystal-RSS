@extends('layouts.app')

@section('title', __('feed.details.title', ['title' => $feedItem->id]))

@section('breadcrumbs')
    {!! Breadcrumbs::render('feed.details', $feedItem) !!}
@endsection

@section('content')
    <h1 class="mb-5">
        @lang('feed.details.title', ['title' => $feedItem->id])
    </h1>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.id'):
        </div>

        <div class="col-md-10">
            {{ $feedItem->id }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.feed_id'):
        </div>

        <div class="col-md-10" {!! $feedItem->feed->getStyle() !!}>
            {{ $feedItem->feed->title }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.url'):
        </div>

        <div class="col-md-10">
            {{ $feedItem->url }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.title'):
        </div>

        <div class="col-md-10">
            {{ $feedItem->title }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.author'):
        </div>

        <div class="col-md-10">
            {{ $feedItem->author }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.content'):
        </div>

        <div class="col-md-10">
            {{ $feedItem->content }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.image_url'):
        </div>

        <div class="col-md-10">
            {{ $feedItem->image_url }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.date'):
        </div>

        <div class="col-md-10">
            {{ $feedItem->posted_at->format(l(DATETIME)) }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.checksum'):
        </div>

        <div class="col-md-10">
            {{ $feedItem->checksum }}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.read_at'):
        </div>

        <div class="col-md-10">
            @if ($feedItem->read_at)
                {{ $feedItem->read_at->format(l(DATETIME)) }}
            @else
                <i>@lang('feed.details.unread')</i>
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('feed.categories'):
        </div>

        <div class="col-md-10">
            @include('feed._categories', ['categories' => $feedItem->categories]):
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.vote_status'):
        </div>

        <div class="col-md-10">
            <span
                    data-provide="voter"
                    data-vote-up-url="{{ route('feed.vote_up', $feedItem, false) }}"
                    data-vote-down-url="{{ route('feed.vote_down', $feedItem, false) }}"
                    data-vote-status="{{ $feedItem->vote_status }}"
            >
            </span>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.favorited_at'):
        </div>

        <div class="col-md-10">
            <span
                data-provide="favoriter"
                data-url="{{ route('feed.toggle_favorite', $feedItem, false) }}"
                data-favorited-at="{{ $feedItem->favorited_at }}"
            >
            </span>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.raw_json'):
        </div>

        <div class="col-md-10">
            <pre class="prettyprint">{{ json_encode($feedItem->getJson(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    </div>

    @if ($feedItem->hasDuplicates())
        <hr/>

        <div class="row mb-2">
            <div class="col-md-2">
                @lang('feed.duplicates'):
            </div>

            <div class="col-md-10">
                <div class="list-group">
                    @foreach ($feedItem->getDuplicates()->get() as $duplicateFeedItem)
                        <a href="{{ route('feed.details', $duplicateFeedItem) }}" class="list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-lg-9 col-8">
                                    #{{ $duplicateFeedItem->id }} {{ $duplicateFeedItem->title }}
                                </div>

                                <div class="col-lg-3 col-4 text-right">
                                    <small>{{ $duplicateFeedItem->posted_at->format(l(DATETIME)) }}</small>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
