@extends('layouts.app')

@section('title', __('update_error.index.title'))

@section('content')
    <h1>
        @lang('update_error.index.title')
        <small class="text-muted">{{ $totalNumberOfUpdateErrors }}</small>
    </h1>

    @if ($updateErrors->count() == 0)
        <p class="lead">
            <i>@lang('update_error.index.none')</i>
        </p>
    @else
        <div class="table-responsive">
            <table class="table table-striped" data-provide="tablesorter">
                <thead>
                    <tr>
                        <th>@lang('validation.attributes.feed_id')</th>
                        <th>@lang('validation.attributes.url')</th>
                        <th>@lang('validation.attributes.created_at')</th>
                        <th class="sorter-false"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($updateErrors as $updateError)
                        <tr>
                            <td>{{ $updateError->feed->title }}</td>
                            <td>{{ $updateError->url }}</td>
                            <td>{{ $updateError->created_at->format(l(DATETIME)) }}</td>
                            <td>{{ Html::linkRoute('update_errors.show', __('common.details'), $updateError) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            @include('shared._pagination', ['items' => $updateErrors])
        </div>
    @endif
@endsection