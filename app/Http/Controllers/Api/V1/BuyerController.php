<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreBuyerRequest;
use App\Http\Requests\UpdateBuyerRequest;
use App\Models\Buyer;
use App\Http\Controllers\Controller;
use App\Models\ShoppingList;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuyerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buyer $buyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuyerRequest $request, Buyer $buyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buyer $buyer)
    {
        //
    }

    public function getShoppingCart()
    {
        $userId = Auth::user()->id;

        // Fetch shopping cart items for the user
        $shoppingCart = ShoppingList::where('buyers_user_id', $userId)->get();

        $products = [];

        foreach ($shoppingCart as $shoppingItem) {
            // Fetch each product related to the shopping cart item
            $product = Product::where('id', $shoppingItem->products_id)->first();

            // Add the fetched product to the $products array
            $products[] = $product;
        }

        return $products;
    }

    public function completeOrder()
    {
        
    }
}
