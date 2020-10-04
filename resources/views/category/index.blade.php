@extends('layouts.app')

@section('title', __('category.index.title'))

@section('content')
    <h1>
        @lang('category.index.title')
        <span class="headline-info">{{ $categories->count() }}</span>
    </h1>

    <p class="mb-5">
        {{ Html::linkRoute('categories.create', __('common.add'), [], ['class' => 'btn btn-primary']) }}
    </p>

    @if ($categories->count() === 0)
        <p class="text-lg italic">@lang('category.index.no_items')</p>
    @else
        <div class="card">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>@lang('validation.attributes.title')</th>
                    <th>@lang('category.index.number_of_feeds')</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories->get() as $category)
                    <tr {!! $category->getStyle(\App\Enums\StyleType::BORDER()) !!}>
                        <td {!! $category->getStyle() !!}>
                            {{ $category->title }}
                        </td>
                        <td>{{ $category->feeds->count() }}</td>
                        <td class="text-right">
                            @include('shared._delete_link', ['route' => ['categories.destroy', $category]])
                            {{ Html::linkRoute('categories.edit', __('common.edit'), $category, ['class' => 'btn btn-sm btn-primary']) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
