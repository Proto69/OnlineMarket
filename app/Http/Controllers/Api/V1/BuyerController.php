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
        // Get the products from the shopping cart
        $products = BuyerController::getShoppingCart();

        // Initialize an empty array to store line items
        $lineItems = [];

        // Iterate over the products and construct line items
        foreach ($products as $product) {
            // Retrieve the quantity from the shopping list
            $quantity = ShoppingList::where('products_id', $product['id'])
                ->where('buyers_user_id', Auth::user()->id)
                ->first()->quantity;

            // Construct each line item
            $lineItems[] = [
                'price' => $product['price_key'],
                'quantity' => $quantity
            ];
        }

        // Get the Stripe API key for the current user
        $stripe_key = Seller::where('user_id', Auth::user()->id)->first()->stripe_key;

        // Initialize the Stripe client
        $stripe = new \Stripe\StripeClient($stripe_key);

        // Create a checkout session
        $session = $stripe->checkout->sessions->create([
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
            'line_items' => $lineItems,
            'mode' => 'payment',
        ]);

        // Redirect the user to the checkout session URL
        return redirect()->away($session->url);
    }
}
