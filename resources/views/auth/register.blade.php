@extends('layouts.app_welcome')

@section('title', __('register.title'))

@section('content')
    <div class="mx-auto w-full max-w-sm bg-white shadow-md rounded text-left">
        <div class="text-xl pb-4 text-gray-600 bg-gray-100 pt-4 pl-8">@lang('register.title')</div>

        {{ Form::open(['route' => 'register', 'method' => 'post', 'role' => 'form', 'class' => 'px-8 pt-6 pb-8 mb-4']) }}
            @captcha

            <div class="mb-4">
                {{ Form::label('name', __('register.name'), ['class' => 'block text-gray-700 text-sm font-bold mb-2']) }}

                {{ Form::text('name', old('name'), ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline transition-all duration-200' . ($errors->has('name') ? ' border-red-500' : ''), 'required' => 'true', 'placeholder' => __('register.name'), 'autofocus' => 'true']) }}

                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs italic pt-2">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="mb-4">
                {{ Form::label('email', __('login.email'), ['class' => 'block text-gray-700 text-sm font-bold mb-2']) }}

                {{ Form::email('email', old('email'), ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline transition-all duration-200' . ($errors->has('email') ? ' border-red-500' : ''), 'required' => true, 'placeholder' => __('login.email')]) }}

                @if ($errors->has('email'))
                    <p class="text-red-500 text-xs italic pt-2">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="mb-4">
                {{ Form::label('password', __('login.password'), ['class' => 'block text-gray-700 text-sm font-bold mb-2']) }}

                {{ Form::password('password', ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline transition-all duration-200' . ($errors->has('password') ? ' border-red-500' : ''), 'required' => true, 'placeholder' => __('login.password')]) }}

                @if ($errors->has('password'))
                    <p class="text-red-500 text-xs italic pt-2">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="mb-4">
                {{ Form::label('password_confirmation', __('register.password_confirmation'), ['class' => 'block text-gray-700 text-sm font-bold mb-2']) }}

                {{ Form::password('password_confirmation', ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline transition-all duration-200' . ($errors->has('password_confirmation') ? ' border-red-500' : ''), 'required' => true, 'placeholder' => __('register.password_confirmation')]) }}

                @if ($errors->has('password_confirmation'))
                    <p class="text-red-500 text-xs italic pt-2">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>

            <div class="pt-4">
                {{ Form::button(__('register.submit'), ['type' => 'submit', 'class' => 'bg-primary hover:bg-black text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-all duration-200']) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection
