@extends('layouts.app')

@section('title', __('feed_manager.archived.title'))

@section('content')
    <h1>
        @lang('feed_manager.archived.title')
        <small class="text-muted">{{ $feeds->count() }}</small>
    </h1>

    <p>
        {{ Html::linkRoute('feed.manage.index', __('common.back')) }}
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
                        <th width="8%">@lang('validation.attributes.is_valid')</th>
                        <th width="16%">@lang('validation.attributes.last_checked_at')</th>
                        <th class="sorter-false"></th>
                        <th class="sorter-false"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feeds->get() as $feed)
                        <tr class="{{ $feed->is_enabled && $feed->is_valid ? '' : 'table-warning' }} {{ !$feed->is_valid ? 'table-danger' : '' }}">
                            <td {!! $feed->getStyle() !!}>
                                {{ $feed->title }}
                            </td>
                            <td>{{ $feed->category->title }}</td>
                            <td>{{ formatBoolean($feed->is_enabled) }}</td>
                            <td>{{ formatBoolean($feed->is_valid) }}</td>
                            <td>{{ $feed->last_checked_at->format(l(DATETIME)) }}</td>
                            <td>
                                @include('shared._delete_link', ['route' => ['feed.manage.destroy_permanently', $feed->id], 'title' => __('common.delete')])
                            </td>
                            <td>
                                {{ Form::open(['route' => ['feed.manage.restore', $feed], 'method' => 'put', 'role' => 'form']) }}
                                    {{ Form::button(__('common.restore'), ['type' => 'submit', 'class' => 'btn btn-link btn-update', 'data-confirm' => '']) }}
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p>
            {{ Html::linkRoute('feed.manage.index', __('common.back')) }}
        </p>
    @endif
@endsection
