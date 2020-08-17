@extends('layouts.app')

@section('title', __('feed_manager.edit.title', ['title' => $feed->title]))

@section('breadcrumbs')
    {!! Breadcrumbs::render('feed.manage.edit', $feed) !!}
@endsection

@section('content')
    <h1>@lang('feed_manager.edit.title', ['title' => $feed->title])</h1>

    {{ Form::open(['route' => ['feed.manage.update', $feed->id], 'method' => 'put', 'role' => 'form']) }}
        <div class="form-group row">
            {{ Form::label('title', __('validation.attributes.title'), ['class' => 'col-lg-3 col-form-label']) }}

            <div class="col-lg-5">
                {{ Form::text('title', old('title', $feed->title), ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'required' => true]) }}

                @if ($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('site_url', __('validation.attributes.site_url'), ['class' => 'col-lg-3 col-form-label']) }}

            <div class="col-lg-5">
                {{ Form::text('site_url', old('site_url', $feed->site_url), ['class' => 'form-control' . ($errors->has('site_url') ? ' is-invalid' : ''), 'required' => true]) }}

                @if ($errors->has('site_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('site_url') }}
                    </div>
                @endif
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

        <div class="form-group row">
            {{ Form::label('is_enabled', __('validation.attributes.is_enabled'), ['class' => 'col-lg-3 col-form-label']) }}

            <div class="col-lg-5">
                {{ Form::select('is_enabled', __('common.lists.boolean'), old('is_enabled', $feed->is_enabled), ['class' => 'form-control' . ($errors->has('is_enabled') ? ' is-invalid' : '')]) }}

                @if ($errors->has('is_enabled'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_enabled') }}
                    </div>
                @endif
            </div>
        </div>

        @include('shared._form_color', ['item' => $feed])

        <div class="form-group row">
            <div class="col-lg-9 ml-md-auto">
                {{ Form::button(__('common.save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection
