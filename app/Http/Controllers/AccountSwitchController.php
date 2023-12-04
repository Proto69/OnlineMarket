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
        $stripeKey = $request->input('stripe_key');
        $user = Auth::user();

        if ($newType === 'Seller' || $newType === 'Buyer') {
            $existingSeller = Seller::where('user_id', $user->id)->first();
            $existingBuyer = Buyer::where('user_id', $user->id)->first();

            if ($newType === 'Seller' && !$existingSeller) {
                // Insert new data for the seller in the 'sellers' table
                Seller::create([
                    'user_id' => $user->id,
                    'stripe_key' => Hash::make($stripeKey), // Additional fields for sellers
                ]);

            } elseif ($newType === 'Buyer' && !$existingBuyer) {
                // Insert new data for the buyer in the 'buyers' table
                Buyer::create([
                    'user_id' => $user->id,
                ]);

            }

            // Update the user's account type
            $user->type = $newType;
            $user->save();
        }

        // Redirect back to the user's profile or another appropriate route
        return redirect()->route('dashboard');
    }
}
