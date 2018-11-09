@extends('layouts.app')

@section('title', __('feed_manager.create.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('feed.manage.create') !!}
@endsection

@section('content')
    <h1>@lang('feed_manager.create.title')</h1>

    {{ Form::open(['route' => 'feed.manage.store', 'method' => 'post', 'role' => 'form']) }}
        <div class="form-group row">
            {{ Form::label('site_or_feed_url', __('validation.attributes.site_or_feed_url'), ['class' => 'col-lg-2 col-form-label']) }}

            <div class="col-lg-5">
                {{ Form::text('site_or_feed_url', old('site_or_feed_url', $feed->site_or_feed_url), ['class' => 'form-control' . ($errors->has('site_or_feed_url') ? ' is-invalid' : ''), 'required' => true]) }}

                @if ($errors->has('site_or_feed_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('site_or_feed_url') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('category_id', __('validation.attributes.category_id'), ['class' => 'col-lg-2 col-form-label']) }}

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
            <div class="col-lg-10 ml-md-auto">
                {{ Form::button(__('common.add'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection