@extends('layouts.app')

@section('title', __('update_error.index.title'))

@section('content')
    <h1>
        @lang('update_error.index.title')
        <span class="headline-info">{{ $totalNumberOfUpdateErrors }}</span>
    </h1>

    <p>
        {{ Form::open(['route' => 'update_errors.clear', 'method' => 'delete', 'role' => 'form', 'class' => 'mb-5']) }}
            {{ Form::button(__('update_error.index.clear'), ['type' => 'submit', 'class' => 'btn btn-danger', 'data-confirm' => '']) }}
        {{ Form::close() }}
    </p>

    @if ($updateErrors->count() === 0)
        <p class="text-lg italic">
            @lang('update_error.index.none')
        </p>
    @else
        <div class="card">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>@lang('validation.attributes.feed_id')</th>
                        <th>@lang('validation.attributes.url')</th>
                        <th>@lang('validation.attributes.created_at')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($updateErrors as $updateError)
                        <tr>
                            <td>
                                @if ($updateError->feed)
                                    {{ $updateError->feed->title }}
                                @else
                                    /
                                @endif
                            </td>
                            <td>{{ $updateError->url }}</td>
                            <td>{{ $updateError->created_at->format(l(DATETIME)) }}</td>
                            <td>{{ Html::linkRoute('update_errors.show', __('common.details'), $updateError, ['class' => 'btn btn-sm btn-primary']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $updateErrors->links() }}
        </div>
    @endif
@endsection
