<span
        class="ml-2"
        data-provide="voter"
        data-vote-up-url="{{ route('feed.vote_up', $feedItem, false) }}"
        data-vote-down-url="{{ route('feed.vote_down', $feedItem, false) }}"
        data-vote-status="{{ $feedItem->vote_status }}"
>
</span>

<span
    class="ml-2"
    data-provide="favoriter"
    data-url="{{ route('feed.toggle_favorite', $feedItem, false) }}"
    data-favorited-at="{{ $feedItem->favorited_at }}"
>
</span>
