<?php

namespace App\Policies;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the feed.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feed  $feed
     * @return mixed
     */
    public function update(User $user, Feed $feed)
    {
        return $feed->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the feed.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feed  $feed
     * @return mixed
     */
    public function delete(User $user, Feed $feed)
    {
        return $feed->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the update error.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feed  $feed
     * @return mixed
     */
    public function restore(User $user, Feed $feed)
    {
        return $feed->user_id == $user->id;
    }

    /**
     * Determine whether the user can permanently delete the feed.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feed  $feed
     * @return mixed
     */
    public function forceDelete(User $user, Feed $feed)
    {
        return $feed->user_id == $user->id;
    }
}
