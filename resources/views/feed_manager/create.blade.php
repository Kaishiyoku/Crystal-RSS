@extends('layouts.app')

@section('title', __('feed_manager.create.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('feed.manage.create') !!}
@endsection

@section('content')
    <h1>@lang('feed_manager.create.title')</h1>

    {{ Form::open(['route' => 'feed.manage.store', 'method' => 'post', 'role' => 'form']) }}
        <div class="form-group row">
            {{ Form::label('site_url', __('validation.attributes.site_url'), ['class' => 'col-lg-3 col-form-label']) }}

            <div class="col-lg-5">
                <div class="input-group">
                    {{ Form::text('site_url', old('site_url', $feed->site_url), ['class' => 'form-control' . ($errors->has('site_url') ? ' is-invalid' : ''), 'required' => true]) }}

                    <div class="input-group-append" id="feedDiscoverButtonContainer"></div>
                </div>

                @if ($errors->has('site_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('site_url') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-3"></div>

            <div class="col-lg-5">
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
        </div>

        <div class="form-group row">
            {{ Form::label('feed_url', __('validation.attributes.feed_url'), ['class' => 'col-lg-3 col-form-label']) }}

            <div class="col-lg-5">
                {{ Form::text('feed_url', old('feed_url', $feed->feed_url), ['class' => 'form-control' . ($errors->has('feed_url') ? ' is-invalid' : ''), 'required' => true]) }}

                @if ($errors->has('feed_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('feed_url') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('category_id', __('validation.attributes.category_id'), ['class' => 'col-lg-3 col-form-label']) }}

            <div class="col-lg-5">
                {{ Form::select('category_id', $categories, old('category_id', $feed->category_id), ['class' => 'form-control' . ($errors->has('category_id') ? ' is-invalid' : '')]) }}

                @if ($errors->has('category_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category_id') }}
                    </div>
                @endif
            </div>
        </div>

        @include('shared._form_color', ['item' => $feed])

        <div class="form-group row">
            <div class="col-lg-9 ml-md-auto">
                {{ Form::button(__('common.add'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection
