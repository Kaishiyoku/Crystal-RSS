@extends('layouts.app')

@section('title', __('category.index.title'))

@section('content')
    <h1>
        @lang('category.index.title')
        <small class="text-muted">{{ $categories->count() }}</small>
    </h1>

    <p>
        {{ Html::linkRoute('categories.create', __('common.add'), [], ['class' => 'btn btn-primary']) }}
    </p>

    @if ($categories->count() == 0)
        <p class="lead"><i>@lang('category.index.no_items')</i></p>
    @else
        <div class="table-responsive">
            <table class="table table-striped" data-provide="tablesorter">
                <thead>
                <tr>
                    <th>@lang('validation.attributes.title')</th>
                    <th>@lang('category.index.number_of_feeds')</th>
                    <th class="sorter-false"></th>
                    <th class="sorter-false"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories->get() as $category)
                    <tr>
                        <td {!! $category->getStyle() !!}>
                            {{ $category->title }}
                        </td>
                        <td>{{ $category->feeds->count() }}</td>
                        <td>
                            @include('shared._delete_link', ['route' => ['categories.destroy', $category->id]])
                        </td>
                        <td>{{ Html::linkRoute('categories.edit', __('common.edit'), [$category->id]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection