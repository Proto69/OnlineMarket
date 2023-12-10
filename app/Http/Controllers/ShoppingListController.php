<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShoppingListRequest;
use App\Http\Requests\UpdateShoppingListRequest;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;

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

    public function addToShoppingList(Request $request)
    {
        $productId = $request->product_id;
        $userId = Auth::user()->id;



        // Retrieve the product based on the provided ID
        $product = Product::find($productId);

        // Check if the product exists and is active
        if ($product && $product->active) {

            $shoppingListItem = ShoppingList::where('buyers_user_id', $userId)->where('products_id', $productId)->first();


            if ($shoppingListItem) {

                $newQuantity = $shoppingListItem->quantity + 1;

                $shoppingListItem->quantity = $newQuantity;

                $shoppingListItem->save();

                return response()->json(['message' => 'Quantity updated successfully']);
            } else {

                ShoppingList::create([
                    'buyers_user_id' => $userId,
                    'products_id' => $productId,
                    'quantity' => 1,
                ]);

                // Return a success response
                return response()->json(['message' => 'Продуктът беше добавен успешно към количката']);
            }
        }

        // Return an error response
        return response()->json(['message' => 'Invalid product or inactive']);
    }
}
