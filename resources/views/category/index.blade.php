@extends('layouts.app')

@section('title', trans('category.index.title'))

@section('content')
    <h1>
        {{ trans('category.index.title') }}
        <small class="text-muted">{{ $categories->count() }}</small>
    </h1>

    <p>
        {{ Html::linkRoute('categories.create', trans('common.add'), [], ['class' => 'btn btn-primary']) }}
    </p>

    @if ($categories->count() == 0)
        <p class="lead"><i>{{ trans('category.index.no_items') }}</i></p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ trans('validation.attributes.title') }}</th>
                <th>{{ trans('category.index.number_of_feeds') }}</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories->get() as $category)
                <tr>
                    <td>{{ $category->title }}</td>
                    <td></td>
                    <td>
                        @include('shared._delete_link', ['route' => ['categories.destroy', $category->id]])
                    </td>
                    <td>{{ Html::linkRoute('categories.edit', trans('common.edit'), [$category->id]) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection