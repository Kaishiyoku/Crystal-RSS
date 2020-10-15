<div class="alert alert-{{ $type ?? 'primary' }}" role="alert">
    {{ $content }}

    @if (isset($link))
        <div class="pt-3">
            {{ $link }}
        </div>
    @endif
</div>
