@extends('layouts.app')

@section('title', __('profile.edit_settings.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('profile.edit_settings') !!}
@endsection

@section('content')
    <h1>{{ __('profile.edit_settings.title') }}</h1>

    {{ Form::open(['route' => 'profile.update_settings', 'method' => 'put', 'role' => 'form']) }}
        <div class="form-group row">
            {{ Form::label('feed_items_per_page', __('validation.attributes.feed_items_per_page'), ['class' => 'col-lg-3 col-form-label']) }}

            <div class="col-lg-3">
                {{ Form::number('feed_items_per_page', old('feed_items_per_page', $settings['feed_items']['per_page']), ['class' => 'form-control' . ($errors->has('feed_items_per_page') ? ' is-invalid' : ''), 'min' => 1, 'max' => 1000, 'required' => true]) }}

                @if ($errors->has('feed_items_per_page'))
                    <div class="invalid-feedback">
                        {{ $errors->first('feed_items_per_page') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-9 ml-md-auto">
                {{ Form::button(__('profile.edit_settings.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection
