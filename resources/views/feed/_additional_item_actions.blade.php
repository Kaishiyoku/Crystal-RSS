<span
        class="ml-2"
        data-provide="voter"
        data-vote-up-url="{{ route('feed.vote_up', $feedItem, false) }}"
        data-vote-down-url="{{ route('feed.vote_down', $feedItem, false) }}"
        data-vote-status="{{ $feedItem->vote_status }}"
>

</span>