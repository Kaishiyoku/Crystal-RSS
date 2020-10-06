@extends('layouts.app')

@section('title', __('statistic.index.title'))

@section('content')
    <h1>
        @lang('statistic.index.title')

        <span class="headline-info">
            @if ($endingDate->isCurrentMonth())
                @lang('statistic.index.last_month')
            @else
                {{ utf8_encode($endingDate->formatLocalized(__('common.localized_date_formats.month_and_year'))) }}
            @endif
        </span>
    </h1>

    <div class="mb-5 text-right">
        <a
            href="{{ route('statistics.index', ['startingYear' => $previousDate->year, 'startingMonth' => $previousDate->month]) }}"
            class="flex btn btn-outline-primary"
        >
            <i class="fas fa-angle-left"></i>
            {{ __('pagination.previous') }}
        </a>

        @if ($nextDate->isBefore(now()))
            <a
                href="{{ route('statistics.index', ['startingYear' => $nextDate->year, 'startingMonth' => $nextDate->month]) }}"
                class="btn btn-outline-primary"
            >
                {{ __('pagination.next') }}
                <i class="fas fa-angle-right"></i>
            </a>
        @endif
    </div>

    @if ($feedItemsCount === 0)
        {{ Html::image('img/no_unread_items.svg', __('feed.index.no_unread_items'), ['class' => 'h-64 mx-auto']) }}

        <p class="italic mt-3 text-center">{{ __('statistic.index.no_data_available') }}</p>
    @else
        <div class="card">
            {!! $dailyArticlesChart->assets() !!}
            {!! $dailyArticlesChart->render() !!}
        </div>
    @endif

    <div class="card my-5 px-2 py-3">
        @if ($feedItemsCount > 0)
            <p class="mb-5">
                @lang('statistic.index.average_time_between_retrieval_and_read'): {{ $averageDurationBetweenRetrievalAndRead->humanize() }}
            </p>
        @endif

        <p>
            @lang('statistic.index.total_number_of_feed_items'): {{ auth()->user()->feedItems()->count() }}
        </p>
    </div>

    <div class="card text-sm md:text-base">
        @foreach ($categories as $category)
            <div class="mb-5">
                <div class="flex font-bold p-2 hover:bg-gray-200 transition-all duration-200">
                    <div class="w-full text-lg" {!! $category->getStyle() !!}>{{ $category->title }}</div>
                    <div class="w-24 text-right">
                        <span class="text-success-900">
                            <i class="fas fa-chevron-up"></i>
                            {{ $category->getTotalUpVoteCount() }}
                        </span>

                        <span class="text-danger-900">
                            <i class="fas fa-chevron-down"></i>
                            {{ $category->getTotalDownVoteCount() }}
                        </span>
                    </div>
                    <div class="w-32 text-lg text-right">{{ $category->getTotalFeedCount() }}</div>
                </div>

                @foreach ($category->feeds as $feed)
                    <div class="flex px-2 pb-1 hover:bg-gray-200 transition-all duration-200">
                        <div class="w-full" {!! $feed->getStyle() !!}>{{ $feed->title }}</div>
                        <div class="w-24 text-right">
                            <span class="text-success-900">
                                <i class="fas fa-chevron-up"></i>
                                {{ $feed->getTotalUpVoteCount() }}
                            </span>

                            <span class="text-danger-900">
                                <i class="fas fa-chevron-down"></i>
                                {{ $feed->getTotalDownVoteCount() }}
                            </span>
                        </div>
                        <div class="w-32 text-right">{{ $feed->feedItems()->count() }}</div>
                    </div>
                @endforeach
            </div>

            <hr/>
        @endforeach
    </div>
@endsection
