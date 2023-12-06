<?php

namespace App\Actions\Fortify;

use App\Models\Team;
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
            'stripe_key' => ['nullable','string']
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'type' => $input['type'],
            ]);

            if ($input['type'] === 'Seller') {
                Seller::create([
                    'user_id' => $user->id,
                    'stripe_key' => Hash::make($input['stripe_key']), // Generate a key here
                ]);
            } elseif ($input['type'] === 'Buyer') {
                Buyer::create([
                    'user_id' => $user->id,
                    // Other fields for Buyer if needed
                ]);
            }

            $user->createToken('personal_token');
            
            return $user;
        });
        
    }
}
