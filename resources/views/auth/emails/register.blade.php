@extends('emails.layouts.app')

@section('title', trans('auth.emails.register.title'))

@section('content')
    <p>
        {{ trans('auth.emails.register.a_new_user_registered') }}:
    </p>

    <p>
        {{ trans('validation.attributes.name') }}: {{ $user->name }}<br>
        {{ trans('validation.attributes.email') }}: {{ $user->email }}
    </p>

    <p>
        {{ trans('auth.emails.register.click_here_to_activate_the_user') }}:

        {{ Html::linkRoute('admin.users.index') }}
    </p>
@endsection