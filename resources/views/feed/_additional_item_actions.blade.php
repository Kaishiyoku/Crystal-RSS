<a
        href="#"
        class="btn btn-xs {{ $feedItem->vote_status == \App\Enums\VoteStatus::Up ? 'btn-success' : 'btn-outline-dark' }}"
        data-vote="{{ route('feed.vote_up', $feedItem) }}" id="vote-up-{{ $feedItem->id }}"
        data-other="#vote-down-{{ $feedItem->id }}"
>
    <i class="fas fa-chevron-up"></i>
</a>

<a
        href="#"
        class="btn btn-xs {{ $feedItem->vote_status == \App\Enums\VoteStatus::Down ? 'btn-danger' : 'btn-outline-dark' }}"
        data-vote="{{ route('feed.vote_down', $feedItem) }}" id="vote-down-{{ $feedItem->id }}"
        data-other="#vote-up-{{ $feedItem->id }}"
>
    <i class="fas fa-chevron-down"></i>
</a>