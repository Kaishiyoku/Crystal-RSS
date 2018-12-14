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
            {{ $feedItem->date->format(l(DATETIME)) }}
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
            @include('feed._categories', ['categories' => $feedItem->categories])
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            @lang('validation.attributes.raw_json'):
        </div>

        <div class="col-md-10">
            <pre class="prettyprint">{{ json_encode($feedItem->getJson(), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
@endsection