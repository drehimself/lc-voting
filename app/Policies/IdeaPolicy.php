<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IdeaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function view(User $user, Idea $idea)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function update(User $user, Idea $idea)
    {
        return $user->id === (int) $idea->user_id
            && now()->subHour() <= $idea->created_at;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function delete(User $user, Idea $idea)
    {
        return $user->id === (int) $idea->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function restore(User $user, Idea $idea)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function forceDelete(User $user, Idea $idea)
    {
        //
    }
}
