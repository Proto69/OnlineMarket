<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Punishment;
use App\Models\User;
use App\Models\Appeal;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function deactivateProduct(Request $request, $productId){
        
        if (Auth::user()->type !== "Admin"){
            abort(404);
        }

        $product = Product::find($productId);
        $punishment = new Punishment();

        $punishment->user_id = $product->seller_user_id; 
        $punishment->product_id = $productId;
        $punishment->reason = $request->reason;

        $punishment->save();

        $product->is_deleted = true;
        $product->save();

        return redirect()->route('products');
    }

    public function activateProduct($productId){
        
        if (Auth::user()->type !== "Admin"){
            abort(404);
        }

        $product = Product::find($productId);
        $punishment = Punishment::where('product_id', $productId)->first();
        $punishment->delete();

        $product->is_deleted = false;
        $product->save();

        return redirect()->route('products');
    }

    public function deactivateAccount($userId){
        
        if (Auth::user()->type !== "Admin"){
            abort(404);
        }

        $user = User::find($userId);
        $user->is_deleted = true;
        $user->save();

        return redirect()->route('users');
    }

    public function activateAccount($userId){
        
        if (Auth::user()->type !== "Admin"){
            abort(404);
        }
        
        $appeal = Appeal::where('user_id', $userId)->first();
        $appeal->delete();

        $user = User::find($userId);
        $user->is_deleted = false;
        $user->save();

        return redirect()->route('users');
    }
}