<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShoppingListRequest;
use App\Http\Requests\UpdateShoppingListRequest;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ShoppingListController extends Controller
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
    public function store(StoreShoppingListRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingList $shoppingList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShoppingList $shoppingList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoppingListRequest $request, ShoppingList $shoppingList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingList $shoppingList)
    {
        //
    }

    public function addToShoppingList(Request $request, $productId)
    {
        // Retrieve the product based on the provided ID
        $product = Product::find($productId);

        // Check if the product exists and is active
        if ($product && $product->active) {
            // Add the product to the shopping list
            ShoppingList::create([
                'buyers_user_id' => Auth::user()->id, // Assuming you have user authentication
                'products_id' => $productId,
                // Add other necessary fields to the shopping list entry
            ]);

            // Set a success message in the session
            Session::flash('success', 'Product added to shopping list.');

            // Return a success response
            return response()->json(['success' => true]);
        }

        // Return an error response
        return response()->json(['error' => 'Invalid product or inactive'], 400);
    }
}
