@extends('layouts.app')

@section('title', __('profile.edit_email.title'))

@section('content')
    <h1>{{ __('profile.edit_email.title') }}</h1>

    {{ Form::open(['route' => 'profile.update_email', 'method' => 'put', 'role' => 'form']) }}
    <div class="form-group row">
        {{ Form::label('current_email', __('validation.attributes.current_email'), ['class' => 'col-lg-3 col-form-label']) }}

        <div class="col-lg-3">
            {{ Form::email('current_email', null, ['class' => 'form-control' . ($errors->has('current_email') ? ' is-invalid' : ''), 'required' => true]) }}

            @if ($errors->has('current_email'))
                <div class="invalid-feedback">
                    {{ $errors->first('current_email') }}
                </div>
            @endif
        </div>
    </div>

    <hr/>

    <div class="form-group row">
        {{ Form::label('new_email', __('validation.attributes.new_email'), ['class' => 'col-lg-3 col-form-label']) }}

        <div class="col-lg-3">
            {{ Form::email('new_email', old('new_email'), ['class' => 'form-control' . ($errors->has('new_email') ? ' is-invalid' : ''), 'required' => true]) }}

            @if ($errors->has('new_email'))
                <div class="invalid-feedback">
                    {{ $errors->first('new_email') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('new_email_confirmation', __('validation.attributes.new_email_confirmation'), ['class' => 'col-lg-3 col-form-label']) }}

        <div class="col-lg-3">
            {{ Form::email('new_email_confirmation', null, ['class' => 'form-control' . ($errors->has('new_email_confirmation') ? ' is-invalid' : ''), 'required' => true]) }}

            @if ($errors->has('new_email_confirmation'))
                <div class="invalid-feedback">
                    {{ $errors->first('new_email_confirmation') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-9 ml-md-auto">
            {{ Form::button(__('profile.edit_email.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
        </div>
    </div>
    {{ Form::close() }}
@endsection
