<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UpdateError;
use Illuminate\Auth\Access\HandlesAuthorization;

class UpdateErrorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the update error.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UpdateError  $updateError
     * @return mixed
     */
    public function view(User $user, UpdateError $updateError)
    {
        return $updateError->user_id == $user->id;
    }

    /**
     * Determine whether the user can create update errors.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the update error.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UpdateError  $updateError
     * @return mixed
     */
    public function update(User $user, UpdateError $updateError)
    {
        return $updateError->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the update error.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UpdateError  $updateError
     * @return mixed
     */
    public function delete(User $user, UpdateError $updateError)
    {
        return $updateError->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the update error.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UpdateError  $updateError
     * @return mixed
     */
    public function restore(User $user, UpdateError $updateError)
    {
        return $updateError->user_id == $user->id;
    }

    /**
     * Determine whether the user can permanently delete the update error.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UpdateError  $updateError
     * @return mixed
     */
    public function forceDelete(User $user, UpdateError $updateError)
    {
        return $updateError->user_id == $user->id;
    }
}
