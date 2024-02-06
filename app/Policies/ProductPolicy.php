<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
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
    public function view(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->type === 'Seller'
            ? Response::allow()
            : Response::deny('You are not a seller.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->seller_user_id
            ? Response::allow()
            : Response::deny('You do not own this product.');
    }

    public function edit(User $user, Product $product): bool
    {
        return $user->id === $product->seller_user_id
            ? Response::allow()
            : Response::deny('You do not own this product.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->seller_user_id
            ? Response::allow()
            : Response::deny('You do not own this product.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->id === $product->seller_user_id
            ? Response::allow()
            : Response::deny('You do not own this product.');
    }
}
