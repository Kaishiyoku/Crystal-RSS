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
     * @param  User $user
     * @param  FeedItem $feedItem
     * @return bool
     */
    public function viewDetails(User $user, FeedItem $feedItem)
    {
        return $feedItem->user_id == $user->id;
    }

    /**
     * Determine whether the user can vote for the feed item.
     *
     * @param User $user
     * @param FeedItem $feedItem
     * @return bool
     */
    public function vote(User $user, FeedItem $feedItem)
    {
        return $feedItem->user_id == $user->id;
    }
}
