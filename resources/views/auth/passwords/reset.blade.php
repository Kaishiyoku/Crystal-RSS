 @extends('layouts.app_welcome')

@section('title', __('password.form_confirm.title'))

@section('content')
    <div class="mx-auto w-full max-w-sm bg-white shadow-md rounded text-left">
        <div class="text-xl pb-4 text-gray-600 bg-gray-100 pt-4 pl-8">@lang('passwords.form_confirm.title')</div>

        {{ Form::open(['url' => '/password/email', 'method' => 'post', 'role' => 'form', 'class' => 'px-8 pt-6 pb-8 mb-4']) }}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4">
                {{ Form::label('email', __('login.email'), ['class' => 'label']) }}

                {{ Form::email('email', old('email'), ['class' => 'input' . ($errors->has('email') ? ' has-error' : ''), 'required' => true, 'autofocus' => 'true', 'placeholder' => __('login.email')]) }}

                @if ($errors->has('email'))
                    <p class="invalid-feedback">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="mb-4">
                {{ Form::label('password', __('validation.attributes.password'), ['class' => 'label']) }}

                {{ Form::password('password', ['class' => 'input' . ($errors->has('password') ? ' has-error' : ''), 'required' => true, 'placeholder' => __('validation.attributes.password')]) }}

                @if ($errors->has('password'))
                    <p class="invalid-feedback">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="mb-4">
                {{ Form::label('password_confirmation', __('validation.attributes.password_confirmation'), ['class' => 'label']) }}

                {{ Form::password('password_confirmation', ['class' => 'input' . ($errors->has('password_confirmation') ? ' has-error' : ''), 'required' => true, 'placeholder' => __('validation.attributes.password_confirmation')]) }}

                @if ($errors->has('password_confirmation'))
                    <p class="invalid-feedback">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>

            <div class="flex items-center justify-between pt-4">
                {{ Form::button(@__('passwords.form_confirm.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection
