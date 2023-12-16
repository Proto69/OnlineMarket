<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function shopping()
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $products = Product::all();

        return view('buyer.index', compact('products'));
    }

    public function shoppingKeyWord(Request $request)
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $keyWord = $request->keyWord;

        $products = Product::where(function ($query) use ($keyWord) {
            $query->where('name', 'like', "%$keyWord%");
        })->get();

        return view('buyer.index', compact('products'));
    }

    public function shoppingCart()
    {
        $typeOfAccount = Auth::user()->type;
        $userId = Auth::user()->id;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $productIds = ShoppingList::where('buyers_user_id', $userId)->get();
        $products = [];

        foreach ($productIds as $item) {
            $product = Product::where('id', $item->products_id)->first();
            $product->bought_quantity = $item->quantity;
            $products[] = $product;
        }

        $sum = 0.00;

        foreach ($products as $product){
            $quantity = ShoppingList::where('products_id', $product->id)->first()->quantity;
            $price = $product->price * $quantity;
            $sum += $price;
        }

        return view('buyer.shopping-cart',['products' => $products], ['sum' => $sum]);
    }

    public function previousPurchases()
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        return view('buyer.previous-purchases');
    }

    public function sellerDashboard()
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Seller') {
            return redirect()->route('shopping');
        }

        return view('seller.index');
    }

    public function sells()
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Seller') {
            abort(404); // If type is not 'Seller', return a 404 not found error
        }

        return view('seller.sells');
    }
}
