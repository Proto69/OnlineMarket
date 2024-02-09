<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ShoppingCartController extends Controller
{
    public function cart()
    {
        $user = Auth::user();

        if ($user->type !== 'Buyer') {
            return response()->json(['error' => 'Не си купувач'], 401);
        }

        $shoppingList = ShoppingList::where('buyers_user_id', $user->id)->get();

        $products = [];

        $sum = 0.00;

        foreach ($shoppingList as $item) {
            $product = Product::find($item->products_id);

            if ($product) {
                $product->bought_quantity = $item->quantity;
                $price = $product->price * $item->quantity;
                $sum += $price;
                $products[] = $product;
            }
        }

        return response()->json(['products' => $products, 'sum' => $sum], 200);
    }
}
