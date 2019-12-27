<?php

namespace App\Policies;

use App\Models\FilterKeyword;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilterKeywordPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create filter keywords.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the filter keyword.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FilterKeyword  $filterKeyword
     * @return mixed
     */
    public function update(User $user, FilterKeyword $filterKeyword)
    {
        return $filterKeyword->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the filter keyword.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FilterKeyword  $filterKeyword
     * @return mixed
     */
    public function delete(User $user, FilterKeyword $filterKeyword)
    {
        return $filterKeyword->user_id == $user->id;
    }
}
