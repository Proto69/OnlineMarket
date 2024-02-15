<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

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
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
				->greeting('Здравей!')
                ->subject('Потвърждаване на имейл адрес')
                ->line('Наскоро в нашият сайт се регистрира потребител с този имейл адрес. Ако това си ти, натисни бутона долу, за да потвърдиш имейл-а си.')
                ->action('Потвърди имейл адрес', $url)
				->salutation('Благодарим за доверието!');
        });
    }
}
