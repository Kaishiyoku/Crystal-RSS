@extends('layouts.app')

@section('title', __('feed_manager.index.title'))

@section('content')
    <h1>
        @lang('feed_manager.index.title')
        <span class="headline-info">{{ $feeds->count() }}</span>
    </h1>

    <p class="mb-5">
        {{ Html::linkRoute('feed.manage.create', __('feed_manager.create.title'), [], ['class' => 'btn btn-primary']) }}

        {{ Html::linkRoute('feed.manage.archived', __('feed_manager.archived.title'), [], ['class' => 'btn btn-outline-primary']) }}
    </p>

    @if ($feeds->count() === 0)
        <p class="text-lg italic">
            @lang('feed_manager.index.no_feeds_yet')
        </p>
    @else
        <div class="card">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>@lang('validation.attributes.title')</th>
                    <th class="hidden md:table-cell">@lang('validation.attributes.category_id')</th>
                    <th class="hidden lg:table-cell">@lang('validation.attributes.is_enabled')</th>
                    <th class="hidden lg:table-cell">@lang('validation.attributes.is_valid')</th>
                    <th class="hidden lg:table-cell">@lang('validation.attributes.last_checked_at')</th>
                    <th class="w-48"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($feeds->get() as $feed)
                    <tr class="{{ $feed->is_enabled && $feed->is_valid ? '' : 'table-warning' }} {{ !$feed->is_valid ? 'table-danger' : '' }}" {!! $feed->getStyle(\App\Enums\StyleType::BORDER()) !!}>
                        <td {!! $feed->getStyle() !!}>
                            {{ $feed->title }}
                        </td>
                        <td class="hidden md:table-cell">{{ $feed->category->title }}</td>
                        <td class="hidden lg:table-cell">{{ formatBoolean($feed->is_enabled) }}</td>
                        <td class="hidden lg:table-cell">{{ formatBoolean($feed->is_valid) }}</td>
                        <td class="hidden lg:table-cell">{{ $feed->last_checked_at->format(l(DATETIME)) }}</td>
                        <td>
                            @include('shared._delete_link', ['route' => ['feed.manage.destroy', $feed], 'title' => __('common.archive')])
                            {{ Html::linkRoute('feed.manage.edit', __('common.edit'), $feed, ['class' => 'btn btn-sm btn-primary']) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
