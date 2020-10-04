@extends('layouts.app_welcome')

@section('title', __('register.title'))

@section('content')
    <div class="mx-auto w-full max-w-sm bg-white shadow-md rounded text-left">
        <div class="text-xl pb-4 text-gray-600 bg-gray-100 pt-4 pl-8">@lang('register.title')</div>

        {{ Form::open(['route' => 'register', 'method' => 'post', 'role' => 'form', 'class' => 'px-8 pt-6 pb-8 mb-4']) }}
            <div class="mb-4">
                {{ Form::label('name', __('register.name'), ['class' => 'label']) }}

                {{ Form::text('name', old('name'), ['class' => 'input' . ($errors->has('name') ? ' has-error' : ''), 'required' => 'true', 'placeholder' => __('register.name'), 'autofocus' => 'true']) }}

                @if ($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="mb-4">
                {{ Form::label('email', __('login.email'), ['class' => 'label']) }}

                {{ Form::email('email', old('email'), ['class' => 'input' . ($errors->has('email') ? ' has-error' : ''), 'required' => true, 'placeholder' => __('login.email')]) }}

                @if ($errors->has('email'))
                    <p class="invalid-feedback">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="mb-4">
                {{ Form::label('password', __('login.password'), ['class' => 'label']) }}

                {{ Form::password('password', ['class' => 'input' . ($errors->has('password') ? ' has-error' : ''), 'required' => true, 'placeholder' => __('login.password')]) }}

                @if ($errors->has('password'))
                    <p class="invalid-feedback">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="mb-4">
                {{ Form::label('password_confirmation', __('register.password_confirmation'), ['class' => 'label']) }}

                {{ Form::password('password_confirmation', ['class' => 'input' . ($errors->has('password_confirmation') ? ' has-error' : ''), 'required' => true, 'placeholder' => __('register.password_confirmation')]) }}

                @if ($errors->has('password_confirmation'))
                    <p class="invalid-feedback">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>

            <div class="pt-4">
                {{ Form::button(__('register.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection
