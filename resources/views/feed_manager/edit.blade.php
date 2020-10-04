@extends('layouts.app')

@section('title', __('feed_manager.edit.title', ['title' => $feed->title]))

@section('breadcrumbs')
    {!! Breadcrumbs::render('feed.manage.edit', $feed) !!}
@endsection

@section('content')
    <h1>@lang('feed_manager.edit.title', ['title' => $feed->title])</h1>

    {{ Form::open(['route' => ['feed.manage.update', $feed], 'method' => 'put', 'role' => 'form']) }}
        <div class="mb-4">
            {{ Form::label('title', __('validation.attributes.title'), ['class' => 'label']) }}

            {{ Form::text('title', old('title', $feed->title), ['class' => 'input' . ($errors->has('title') ? ' has-error' : ''), 'required' => true]) }}

            @if ($errors->has('title'))
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
            @endif
        </div>

        <div class="mb-4">
            {{ Form::label('site_url', __('validation.attributes.site_url'), ['class' => 'label']) }}

            {{ Form::text('site_url', old('site_url', $feed->site_url), ['class' => 'input' . ($errors->has('site_url') ? ' has-error' : ''), 'required' => true]) }}

            @if ($errors->has('site_url'))
                <div class="invalid-feedback">
                    {{ $errors->first('site_url') }}
                </div>
            @endif
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

        <div class="mb-4">
            {{ Form::label('is_enabled', __('validation.attributes.is_enabled'), ['class' => 'label']) }}

            {{ Form::select('is_enabled', __('common.lists.boolean'), old('is_enabled', $feed->is_enabled), ['class' => 'input' . ($errors->has('is_enabled') ? ' has-error' : '')]) }}

            @if ($errors->has('is_enabled'))
                <div class="invalid-feedback">
                    {{ $errors->first('is_enabled') }}
                </div>
            @endif
        </div>

        @include('shared._form_color', ['item' => $feed])

        <div class="form-group row">
            <div class="col-lg-9 ml-md-auto">
                {{ Form::button(__('common.save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection
