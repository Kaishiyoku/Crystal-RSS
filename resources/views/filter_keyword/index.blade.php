@extends('layouts.app')

@section('title', __('filter_keyword.index.title'))

@section('content')
    <h1>
        @lang('filter_keyword.index.title')
        <small class="text-muted">{{ $filterKeywords->count() }}</small>
    </h1>

    <p class="mb-5">
        {{ Html::linkRoute('filter_keywords.create', __('common.add'), [], ['class' => 'btn btn-primary']) }}
    </p>

    @if ($filterKeywords->count() == 0)
        <p class="text-lg italic">@lang('filter_keyword.index.no_items')</p>
    @else
        <div class="card mt-5">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>@lang('validation.attributes.value')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filterKeywords->get() as $filterKeyword)
                        <tr>
                            <td>
                                {{ $filterKeyword->value }}
                            </td>
                            <td class="text-right">
                                @include('shared._delete_link', ['route' => ['filter_keywords.destroy', $filterKeyword]])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
