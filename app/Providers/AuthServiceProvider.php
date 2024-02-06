<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\ShoppingList' => 'App\Policies\ShoppingListPolicy',
        'App\Models\Log' => 'App\Policies\LogPolicy',
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\Buyer' => 'App\Policies\BuyerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
    }
}
