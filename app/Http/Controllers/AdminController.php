<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Punishment;
use App\Models\User;
use App\Models\Appeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PunishmentBan;
use App\Mail\PunishmentCanceled;
use App\Mail\PunishmentRecieved;
use App\Models\Comment;

class AdminController extends Controller
{
    public function deactivateProduct(Request $request, $productId)
    {

        if (Auth::user()->type !== "Admin") {
            abort(404);
        }

        $product = Product::find($productId);
        $punishment = new Punishment();

        $punishment->user_id = $product->seller_user_id;
        $punishment->object_id = $productId;
        $punishment->reason = $request->reason;
        $punishment->is_product = true;

        $punishment->save();

        $product->is_deleted = true;
        $product->save();

        Mail::to(User::find($product->seller_user_id))->send(new PunishmentRecieved($punishment));

        return redirect()->route('products');
    }

    public function activateProduct($productId)
    {

        if (Auth::user()->type !== "Admin") {
            abort(404);
        }

        $product = Product::find($productId);
        $punishment = Punishment::where('object_id', $productId)->where('is_product', true)->first();
        if ($punishment) {
            $punishment->delete();
        }

        $product->is_deleted = false;
        $product->save();

        Mail::to(User::find($product->seller_user_id))->send(new PunishmentCanceled($punishment));

        return redirect()->route('products');
    }

    public function deactivateComment(Request $request, $reviewId)
    {

        if (Auth::user()->type !== "Admin") {
            abort(404);
        }

        $review = Comment::find($reviewId);
        $punishment = new Punishment();

        $punishment->user_id = $review->user_id;
        $punishment->object_id = $reviewId;
        $punishment->reason = $request->reason;
        $punishment->is_product = false;

        $punishment->save();

        $review->is_deleted = true;
        $review->save();

        Mail::to(User::find($review->user_id))->send(new PunishmentRecieved($punishment));

        return redirect()->route('products');
    }

    public function activateComment($reviewId)
    {

        if (Auth::user()->type !== "Admin") {
            abort(404);
        }

        $review = Comment::find($reviewId);
        $punishment = Punishment::where('object_id', $reviewId)->where('is_product', false)->first();
        if ($punishment) {
            $punishment->delete();
        }

        $review->is_deleted = false;
        $review->save();

        Mail::to(User::find($review->user_id))->send(new PunishmentCanceled($punishment));

        return redirect()->route('products');
    }

    public function deactivateAccount($userId)
    {

        if (Auth::user()->type !== "Admin") {
            abort(404);
        }

        $user = User::find($userId);
        $user->is_deleted = true;
        $user->save();

        Mail::to($user)->send(new PunishmentBan());

        return redirect()->route('users');
    }

    public function activateAccount($userId)
    {

        if (Auth::user()->type !== "Admin") {
            abort(404);
        }

        $appeal = Appeal::where('user_id', $userId)->first();
        if ($appeal) {
            $appeal->delete();
        }

        $user = User::find($userId);
        $user->is_deleted = false;
        $user->save();

        Mail::to($user)->send(new PunishmentCanceled($punishment));

        return redirect()->route('users');
    }
}
