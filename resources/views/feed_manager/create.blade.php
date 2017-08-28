@extends('layouts.app')

@section('title', trans('feed_manager.create.title'))

@section('content')
    <h1>{{ trans('feed_manager.create.title') }}</h1>

    {{ Form::open(['route' => 'feed.manage.store', 'method' => 'post', 'role' => 'form']) }}
        <div class="form-group row">
            {{ Form::label('site_or_feed_url', trans('validation.attributes.site_or_feed_url'), ['class' => 'col-lg-2 col-form-label']) }}

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
            <div class="col-lg-10 ml-md-auto">
                {{ Form::button(trans('common.add'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection