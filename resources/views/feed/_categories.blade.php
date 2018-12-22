@if ($categories->count() == 0)
    <i>@lang('common.none')</i>
@else
    @foreach ($categories as $category)
        <span class="badge badge-dark">{{ $category->title }}</span>
    @endforeach
@endif