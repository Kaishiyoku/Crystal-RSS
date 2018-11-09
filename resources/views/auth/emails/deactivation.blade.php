@extends('emails.layouts.app')

@section('title', __('auth.emails.deactivation.title'))

@section('content')
    <p>
        {{ __('auth.emails.deactivation.your_account_has_been_deactivated', ['name' => $user->name]) }}
    </p>
@endsection