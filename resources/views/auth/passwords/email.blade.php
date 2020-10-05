@extends('layouts.app_welcome')

@section('title', __('passwords.form.title'))

@section('content')
    <div class="mx-auto w-full max-w-sm bg-white shadow-md rounded text-left">
        <div class="text-xl pb-4 text-gray-600 bg-gray-100 pt-4 pl-8">@lang('passwords.form.title')</div>

        {{ Form::open(['url' => '/password/email', 'method' => 'post', 'role' => 'form', 'class' => 'px-8 pt-6 pb-8 mb-4']) }}
            {{ Form::label('email', __('login.email'), ['class' => 'label']) }}

            <div class="mb-4">
                {{ Form::email('email', old('email'), ['class' => 'input' . ($errors->has('email') ? ' has-error' : ''), 'required' => true, 'autofocus' => 'true', 'placeholder' => __('login.email')]) }}

                @if ($errors->has('email'))
                    <p class="invalid-feedback">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="flex items-center justify-between pt-4">
                {{ Form::button(__('passwords.form.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
           $('#email').focus();
        });
    </script>
@endsection
