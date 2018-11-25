@if ($categories->count() == 0)
    <i>@lang('common.none')</i>
@else
    @foreach ($categories as $category)
        <span class="badge badge-secondary">{{ $category->title }}</span>
    @endforeach
@endif