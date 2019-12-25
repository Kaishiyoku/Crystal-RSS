<div class="alert alert-{{ $type ?? 'primary' }}" role="alert">
    {{ $content }}

    @if (isset($link))
        <div>
            {{ $link }}
        </div>
    @endif
</div>
