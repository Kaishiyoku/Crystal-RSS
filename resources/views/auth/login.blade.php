@extends('layouts.app')

@section('title', trans('login.title'))

@section('content')
    @include('shared._login')
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#email').focus();
        });
    </script>
@endsection