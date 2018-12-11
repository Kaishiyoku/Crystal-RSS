@extends('layouts.app')

@section('title', __('statistic.index.title'))

@section('content')
    <div>
        {!! $dailyArticlesChart->container() !!}
        {!! $dailyArticlesChart->script() !!}
    </div>

    <div>
        {!! $categoriesChart->container() !!}
        {!! $categoriesChart->script() !!}
    </div>

    <p class="pt-5">
        @lang('statistic.index.average_time_between_retrieval_and_read'): {{ $averageDurationBetweenRetrievalAndRead->humanize() }}
    </p>
@endsection