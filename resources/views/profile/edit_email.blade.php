@extends('layouts.app')

@section('title', __('profile.edit_email.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('profile.edit_email') !!}
@endsection

@section('content')
    <h1>{{ __('profile.edit_email.title') }}</h1>

    {{ Form::open(['route' => 'profile.update_email', 'method' => 'put', 'role' => 'form']) }}
        <div class="mb-4">
            {{ Form::label('current_email', __('validation.attributes.current_email'), ['class' => 'label']) }}

            {{ Form::email('current_email', null, ['class' => 'input' . ($errors->has('current_email') ? ' has-error' : ''), 'required' => true]) }}

            @if ($errors->has('current_email'))
                <div class="invalid-feedback">
                    {{ $errors->first('current_email') }}
                </div>
            @endif
        </div>

        <hr/>

        <div class="mb-4">
            {{ Form::label('new_email', __('validation.attributes.new_email'), ['class' => 'label']) }}

            {{ Form::email('new_email', old('new_email'), ['class' => 'input' . ($errors->has('new_email') ? ' has-error' : ''), 'required' => true]) }}

            @if ($errors->has('new_email'))
                <div class="invalid-feedback">
                    {{ $errors->first('new_email') }}
                </div>
            @endif
        </div>

        <div class="mb-4">
            {{ Form::label('new_email_confirmation', __('validation.attributes.new_email_confirmation'), ['class' => 'label']) }}

            {{ Form::email('new_email_confirmation', null, ['class' => 'input' . ($errors->has('new_email_confirmation') ? ' has-error' : ''), 'required' => true]) }}

            @if ($errors->has('new_email_confirmation'))
                <div class="invalid-feedback">
                    {{ $errors->first('new_email_confirmation') }}
                </div>
            @endif
        </div>

        {{ Form::button(__('profile.edit_email.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
