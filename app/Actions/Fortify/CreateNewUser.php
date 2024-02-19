<?php

namespace App\Actions\Fortify;

use Stripe;
use App\Models\User;
use App\Models\Seller;
use App\Models\Buyer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['required', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : ''
        ], [
            'name.max' => __('Името е твърде дълго!'),
            'name.required' => __('Полето за име е задължително!'),
            'email.required' => __('Полето за имейл адрес е задължително!'),
            'email.email' => __('Моля, въведете валиден имейл адрес!'),
            'email.max' => __('Имейл адресът е твърде дълъг!'),
            'email.unique' => __('Имейл адресът вече е регистриран!'),
            'password.required' => __('Полето за парола е задължително!'),
            'password.string' => __('Паролата трябва да бъде текст!'),
            'password.confirmed' => __('Паролите не съвпадат!'),
            'password.min' => __('Паролата трябва да бъде поне :min знака!'),
            'terms.accepted' => __('За да продължите, трябва да приемете условията.'),
            'terms.required' => __('За да продължите, трябва да приемете условията.'),
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'type' => $input['type'],
            ]);


            if ($input['type'] === 'Seller') {

                $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));
                $account = $stripe->accounts->create([
                    'type' => 'standard'
                ]);

                Seller::create([
                    'user_id' => $user->id,
                    'account_id' => $account->id
                ]);

                
            } elseif ($input['type'] === 'Buyer') {
                Buyer::create([
                    'user_id' => $user->id,
                ]);
            }

            return $user;
        });
    }
}
