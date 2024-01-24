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
            
            $token = $user->tokens->first();

            if ($token) {
                return response()->json(['token' => $token->plainTextToken], 200);
            } else {
                return response()->json(['error' => 'No tokens found for this user'], 404);
            }
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
