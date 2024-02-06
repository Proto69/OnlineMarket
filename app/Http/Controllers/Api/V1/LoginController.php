<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {

            $token = $user->createToken('app_access', ['*'], now()->addDays(7))->plainTextToken;

            if ($token !== null) {
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'No tokens found for this user'], 404);
            }
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function validateToken()
    {
        return response()->json(['message' => 'Token is valid'], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

    public function whatAmI()
    {
        $user = auth()->user();

        return response()->json(['type' => $user->type], 200);
    }

    public function changeMyType(Request $request)
    {
        $user = auth()->user();

        if ($user->type === $request->type) {
            return response()->json(['error' => 'You are already a ' . $request->type], 400);
        }
        if ($request->type === 'Buyer' || $request->type === 'Seller') {
            $user->type = $request->type;
            if ($request->type === 'Buyer' || $request->type === 'Seller') {
                $user->type = $request->type;
                $user->save();
            } else {
                return response()->json(['error' => 'Invalid type'], 400);
            }

            return response()->json(['message' => 'Type changed'], 200);
        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        return response()->json(['message' => 'Type changed'], 200);
    }
}
