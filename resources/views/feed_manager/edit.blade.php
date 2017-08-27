@extends('layouts.app')

@section('title', trans('feed_manager.edit.title'))

@section('content')
    <h1>{{ trans('feed_manager.edit.title', ['title' => $feed->title]) }}</h1>

    {{ Form::open(['route' => ['manage_feeds.update', $feed->id], 'method' => 'put', 'role' => 'form']) }}
        <div class="form-group row">
            {{ Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 col-form-label']) }}

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
            {{ Form::label('site_url', trans('validation.attributes.site_url'), ['class' => 'col-lg-2 col-form-label']) }}

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
            {{ Form::label('feed_url', trans('validation.attributes.feed_url'), ['class' => 'col-lg-2 col-form-label']) }}

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
            <div class="col-lg-10 ml-md-auto">
                {{ Form::button(trans('common.save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection