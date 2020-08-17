@extends('layouts.app')

@section('title', __('filter_keyword.index.title'))

@section('content')
    <h1>
        @lang('filter_keyword.index.title')
        <small class="text-muted">{{ $filterKeywords->count() }}</small>
    </h1>

    <p>
        {{ Html::linkRoute('filter_keywords.create', __('common.add'), [], ['class' => 'btn btn-primary']) }}
    </p>

    @if ($filterKeywords->count() == 0)
        <p class="lead"><i>@lang('filter_keyword.index.no_items')</i></p>
    @else
        <div class="table-responsive">
            <table class="table table-striped" data-provide="tablesorter">
                <thead>
                    <tr>
                        <th>@lang('validation.attributes.value')</th>
                        <th class="sorter-false"></th>
                        <th class="sorter-false"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filterKeywords->get() as $filterKeyword)
                        <tr>
                            <td>
                                {{ $filterKeyword->value }}
                            </td>
                            <td>
                                @include('shared._delete_link', ['route' => ['filter_keywords.destroy', $filterKeyword]])
                            </td>
                            <td>{{ Html::linkRoute('filter_keywords.edit', __('common.edit'), [$filterKeyword]) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection