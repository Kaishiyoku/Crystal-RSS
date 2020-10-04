@extends('layouts.app')

@section('title', __('profile.edit_settings.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('profile.edit_settings') !!}
@endsection

@section('content')
    <h1>{{ __('profile.edit_settings.title') }}</h1>

    {{ Form::open(['route' => 'profile.update_settings', 'method' => 'put', 'role' => 'form']) }}
        <div class="mb-4">
            {{ Form::label('feed_items_per_page', __('validation.attributes.feed_items_per_page'), ['class' => 'label']) }}

            {{ Form::number('feed_items_per_page', old('feed_items_per_page', $settings['feed_items']['per_page']), ['class' => 'input' . ($errors->has('feed_items_per_page') ? ' has-error' : ''), 'min' => 1, 'max' => 1000, 'required' => true]) }}

            @if ($errors->has('feed_items_per_page'))
                <div class="invalid-feedback">
                    {{ $errors->first('feed_items_per_page') }}
                </div>
            @endif
        </div>

        <div class="mb-4">
            {{ Form::label('feed_items_mark_duplicates_as_read_automatically', __('validation.attributes.feed_items_mark_duplicates_as_read_automatically'), ['class' => 'label']) }}

            {{ Form::select('feed_items_mark_duplicates_as_read_automatically', __('common.lists.boolean'), old('feed_items_mark_duplicates_as_read_automatically', $settings['feed_items']['mark_duplicates_as_read_automatically']), ['class' => 'input' . ($errors->has('feed_items_mark_duplicates_as_read_automatically') ? ' has-error' : '')]) }}

            @if ($errors->has('feed_items_mark_duplicates_as_read_automatically'))
                <div class="invalid-feedback">
                    {{ $errors->first('feed_items_mark_duplicates_as_read_automatically') }}
                </div>
            @endif
        </div>

        {{ Form::button(__('profile.edit_settings.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
