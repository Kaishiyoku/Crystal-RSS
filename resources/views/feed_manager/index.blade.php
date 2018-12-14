@extends('layouts.app')

@section('title', __('feed_manager.index.title'))

@section('content')
    <h1>
        @lang('feed_manager.index.title')
        <small class="text-muted">{{ $feeds->count() }}</small>
    </h1>

    <p>
        {{ Html::linkRoute('feed.manage.create', __('feed_manager.create.title'), [], ['class' => 'btn btn-primary']) }}
    </p>

    @if ($feeds->count() == 0)
        <p class="lead">
            <i>@lang('feed_manager.index.no_feeds_yet')</i>
        </p>
    @else
        <div class="table-responsive">
            <table class="table table-striped" data-provide="tablesorter">
                <thead>
                <tr>
                    <th>@lang('validation.attributes.title')</th>
                    <th>@lang('validation.attributes.category_id')</th>
                    <th width="7%">@lang('validation.attributes.is_enabled')</th>
                    <th>@lang('validation.attributes.last_checked_at')</th>
                    <th class="sorter-false"></th>
                    <th class="sorter-false"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($feeds->get() as $feed)
                    <tr class="{{ $feed->is_enabled ? '' : 'table-warning' }}">
                        <td {!! $feed->getStyle() !!}>
                            {{ $feed->title }}
                        </td>
                        <td>{{ $feed->category->title }}</td>
                        <td>{{ formatBoolean($feed->is_enabled) }}</td>
                        <td>{{ $feed->last_checked_at->format(l(DATETIME)) }}</td>
                        <td>
                            @include('shared._delete_link', ['route' => ['feed.manage.destroy', $feed->id]])
                        </td>
                        <td>{{ Html::linkRoute('feed.manage.edit', __('common.edit'), [$feed->id]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection