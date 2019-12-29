@extends('layouts.app_welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-md-2"></div>

            <div class="col-md-6">
                <h1>{{ __('home.contact.title') }}</h1>
            </div>
        </div>

        {{ Form::open(['route' => 'home.contact_send', 'method' => 'post']) }}
            <div class="form-group row">
                {{ Form::label('email', __('validation.attributes.email'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

                <div class="col-md-6">
                    {{ Form::text('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : '')]) }}

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('name', __('validation.attributes.name'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

                <div class="col-md-6">
                    {{ Form::text('name', old('name'), ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '')]) }}

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('content', __('validation.attributes.content'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

                <div class="col-md-6">
                    {{ Form::textarea('content', old('content'), ['class' => 'form-control' . ($errors->has('content') ? ' is-invalid' : '')]) }}

                    @error('content')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-md-2 col-md-2"></div>

                <div class="col-md-5">
                    {{ Form::button(__('common.send'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection
