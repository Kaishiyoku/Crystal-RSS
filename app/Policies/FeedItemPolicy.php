<?php

namespace App\Policies;

use App\Models\FeedItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the feed item.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FeedItem  $feedItem
     * @return mixed
     */
    public function viewDetails(User $user, FeedItem $feedItem)
    {
        return $feedItem->user_id == $user->id;
    }
}
