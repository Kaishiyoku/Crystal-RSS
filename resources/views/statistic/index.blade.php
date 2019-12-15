@extends('layouts.app')

@section('title', __('statistic.index.title'))

@section('content')
    <h1>
        @lang('statistic.index.title')

        <small class="text-muted">
            @lang('statistic.index.last_month')
        </small>
    </h1>

    <div>
        {!! $dailyArticlesChart->container() !!}
        {!! $dailyArticlesChart->script() !!}
    </div>

    <p class="pt-5">
        @lang('statistic.index.average_time_between_retrieval_and_read'): {{ $averageDurationBetweenRetrievalAndRead->humanize() }}
    </p>

    <p>
        Artikel gesamt: {{ auth()->user()->feedItems()->count() }}
    </p>

    @foreach ($categories as $category)
        <div class="row mt-3">
            <div class="col-xl-6 col-lg-8 col-12 border-bottom hoverable">
                <div class="row">
                    <div class="col-7 font-weight-bold" {!! $category->getStyle() !!}>{{ $category->title }}</div>
                    <div class="col-3">
                        <span class="text-success">
                            <i class="fas fa-chevron-up"></i>
                            {{ $category->getTotalUpVoteCount() }}
                        </span>

                        <span class="text-danger">
                            <i class="fas fa-chevron-down"></i>
                            {{ $category->getTotalDownVoteCount() }}
                        </span>
                    </div>
                    <div class="col-2 text-right font-weight-bold">{{ $category->getTotalFeedCount() }}</div>
                </div>
            </div>
        </div>

        @foreach ($category->feeds as $feed)
            <div class="row">
                <div class="col-xl-6 col-lg-8 col-12 hoverable">
                    <div class="row">
                        <div class="col-7" {!! $feed->getStyle() !!}>{{ $feed->title }}</div>
                        <div class="col-3">
                            <span class="text-success">
                                <i class="fas fa-chevron-up"></i>
                                {{ $feed->getTotalUpVoteCount() }}
                            </span>

                            <span class="text-danger">
                                <i class="fas fa-chevron-down"></i>
                                {{ $feed->getTotalDownVoteCount() }}
                            </span>
                        </div>
                        <div class="col-2 text-right">{{ $feed->feedItems()->count() }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
@endsection
