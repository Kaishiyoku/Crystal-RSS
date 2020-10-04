@extends('layouts.app')

@section('title', __('feed_manager.create.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('feed.manage.create') !!}
@endsection

@section('content')
    <h1>@lang('feed_manager.create.title')</h1>

    {{ Form::open(['route' => 'feed.manage.store', 'method' => 'post', 'role' => 'form']) }}
        <div class="mb-4">
            {{ Form::label('site_url', __('validation.attributes.site_url'), ['class' => 'label']) }}

            <div class="col-lg-5">
                <div class="flex">
                    <div class="flex-grow">
                        {{ Form::text('site_url', old('site_url', $feed->site_url), ['class' => 'input input-with-btn' . ($errors->has('site_url') ? ' has-error' : ''), 'required' => true]) }}

                        @if ($errors->has('site_url'))
                            <div class="invalid-feedback">
                                {{ $errors->first('site_url') }}
                            </div>
                        @endif
                    </div>
                    <div id="feedDiscoverButtonContainer"></div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div
                data-provide="feed-discoverer"
                data-url="{{ route('feed.manage.discover') }}"
                data-site-input-id="site_url"
                data-feed-input-id="feed_url"
                data-feed-discover-button-container-id="feedDiscoverButtonContainer"
                data-translations="{{ json_encode(__('feed_manager.feed_discoverer'), JSON_THROW_ON_ERROR) }}"
            >
            </div>
        </div>

        <div class="mb-4">
            {{ Form::label('feed_url', __('validation.attributes.feed_url'), ['class' => 'label']) }}

            {{ Form::text('feed_url', old('feed_url', $feed->feed_url), ['class' => 'input' . ($errors->has('feed_url') ? ' has-error' : ''), 'required' => true]) }}

            @if ($errors->has('feed_url'))
                <div class="invalid-feedback">
                    {{ $errors->first('feed_url') }}
                </div>
            @endif
        </div>

        <div class="mb-4">
            {{ Form::label('category_id', __('validation.attributes.category_id'), ['class' => 'label']) }}

            {{ Form::select('category_id', $categories, old('category_id', $feed->category_id), ['class' => 'input' . ($errors->has('category_id') ? ' has-error' : '')]) }}

            @if ($errors->has('category_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('category_id') }}
                </div>
            @endif
        </div>

        @include('shared._form_color', ['item' => $feed])

        {{ Form::button(__('common.add'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
