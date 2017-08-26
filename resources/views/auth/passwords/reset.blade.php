 @extends('layouts.app')

@section('title', trans('password.reset.title'))

@section('content')
    <div class="row justify-content-md-center">
        <div class="col col-lg-8">
            <div class="card border-primary">
                <h4 class="card-header text-white bg-primary">
                    {{ trans('passwords.reset.title') }}
                </h4>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ Form::open(['url' => '/password/reset', 'method' => 'post', 'role' => 'form']) }}
                        {{ Form::hidden('token', $token) }}

                        <div class="form-group row">
                            {{ Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-4 col-form-label']) }}

                            <div class="col-lg-6">
                                {{ Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required' => true]) }}

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('password', trans('validation.attributes.password'), ['class' => 'col-lg-4 col-form-label']) }}

                            <div class="col-lg-6">
                                {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'required' => true]) }}

                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), ['class' => 'col-lg-4 col-form-label']) }}

                            <div class="col-lg-6">
                                {{ Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'required' => true]) }}

                                @if ($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-8 ml-md-auto">
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('passwords.reset.submit') }}
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection