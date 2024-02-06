<?php

namespace App\Policies;

use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShoppingListPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->buyers_user_id
            ? Response::allow()
            : Response::deny('You do not own this shopping list.');
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
    public function update(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->buyers_user_id
            ? Response::allow()
            : Response::deny('You do not own this shopping list.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->buyers_user_id
            ? Response::allow()
            : Response::deny('You do not own this shopping list.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShoppingList $shoppingList): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->buyers_user_id
            ? Response::allow()
            : Response::deny('You do not own this shopping list.');
    }
}
