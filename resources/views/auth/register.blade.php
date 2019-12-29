@extends('layouts.app_welcome')

@section('title', __('register.title'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-md-2"></div>

            <div class="col-md-6">
                <h1>@lang('register.title')</h1>
            </div>
        </div>


        {{ Form::open(['route' => 'register', 'method' => 'post', 'role' => 'form']) }}
            @captcha()

            <div class="form-group row">
                {{ Form::label('name', __('register.name'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

                <div class="col-md-6">
                    {{ Form::text('name', old('name'), ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'required' => 'true']) }}

                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('email', __('register.email'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

                <div class="col-md-6">
                    {{ Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required' => true]) }}

                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('password', __('register.password'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

                <div class="col-md-6">
                    {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'required' => true, 'data-provide' => 'password-strength', 'data-username-field' => '#name']) }}

                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('password_confirmation', __('register.password_confirmation'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

                <div class="col-md-6">
                    {{ Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'required' => true]) }}

                    @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-2 col-md-2"></div>

                <div class="col-md-5">
                    {{ Form::button(__('register.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#name').focus();
        });
    </script>
@endsection
