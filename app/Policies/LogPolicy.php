<?php

namespace App\Policies;

use App\Models\Log;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Response::deny('You cannot view any logs.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Log $log): bool
    {
        return $user->id === $log->user_id
            ? Response::allow()
            : Response::deny('You do not own this log.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->type === 'Buyer'
            ? Response::allow()
            : Response::deny('You are not a buyer.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Log $log): bool
    {
        return Response::deny('You cannot update a log.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Log $log): bool
    {
        return Response::deny('You cannot delete a log.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Log $log): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Log $log): bool
    {
        return Response::deny('You cannot permanently delete a log.');
    }
}
