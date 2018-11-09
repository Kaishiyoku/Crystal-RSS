@extends('emails.layouts.app')

@section('title', __('auth.emails.activation.title'))

@section('content')
    <p>
        {{ __('auth.emails.activation.your_account_has_been_activated', ['name' => $user->name]) }}
    </p>

    <p>
        {{ __('auth.emails.activation.you_may_login_now') }}: {{ Html::linkRoute('login') }}
    </p>
@endsection