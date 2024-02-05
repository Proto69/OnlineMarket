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
            'password' => $this->passwordRules(),
            'type' => ['required', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'stripe_key' => ['nullable', 'string']
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'type' => $input['type'],
            ]);


            if ($input['type'] === 'Seller') {

                $stripe = new \Stripe\StripeClient('sk_test_51Oeyd6CSzZqinv6YQITQ0PKH67oGMrXHUYhp9N8rWF7EMZilZhqPuvQIhkhwSW40o5qmvDL2igC3Psow6JXtYqNa00enz66uGE');
                $account = $stripe->accounts->create([
                    'type' => 'standard'
                ]);

                $accountLink = $stripe->accountLinks->create([
                    'account' => $account->id,
                    'refresh_url' => route('refresh-stripe'),
                    'return_url' => route('return-stripe'),
                    'type' => 'account_onboarding',
                  ]);

                  redirect($accountLink->url);

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
