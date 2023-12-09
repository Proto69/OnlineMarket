<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Support\Facades\Auth;



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

    public function shoppingCart()
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        return view('buyer.shopping-cart');
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
            abort(404); // If type is not 'Seller', return a 404 not found error
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
