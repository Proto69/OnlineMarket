<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;
use App\Models\Buyer;
use Illuminate\Support\Facades\Hash;

class AccountSwitchController extends Controller
{
    public function switchAccount(Request $request)
    {
        $newType = $request->input('newType');
        $user = Auth::user();

        $existingSeller = Seller::where('user_id', $user->id)->first();
        $existingBuyer = Buyer::where('user_id', $user->id)->first();

        if ($newType === 'Seller' && !$existingSeller) {

            $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));
            $account = $stripe->accounts->create([
                'type' => 'standard'
            ]);

            Seller::create([
                'user_id' => $user->id,
                'account_id' => $account->id
            ]);

            $user->type = $newType;
            $user->save();

            return redirect('connect-stripe');
            
        } elseif ($newType === 'Buyer' && !$existingBuyer) {
            // Insert new data for the buyer in the 'buyers' table
            Buyer::create([
                'user_id' => $user->id,
            ]);
        }

        // Update the user's account type
        $user->type = $newType;
        $user->save();


        if ($newType === 'Seller')
            return redirect()->route('dashboard');
        else
            return redirect()->route('shopping');
    }
}
