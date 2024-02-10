<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreBuyerRequest;
use App\Http\Requests\UpdateBuyerRequest;
use App\Models\Buyer;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\ShoppingList;
use App\Models\Product;
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
        $shoppingCart = $shoppingCart = ShoppingList::where('buyers_user_id', Auth::user()->id)->get();

        $lineItems = [];
        $totalPrice = 0;

        // Iterate through the $checkout array to create line items
        foreach ($shoppingCart as $item) {

            $product = Product::where('id', $item->products_id)->first();
            
            $totalPrice += $product->price * $item->quantity;

            if ($product)
            // Add each product as a line item
            {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'bgn', // Adjust currency as needed
                        'product_data' => [
                            'name' => $product->name, // Product name from $checkout array
                        ],
                        'unit_amount' => $product->price * 100, // Adjust unit amount as needed
                    ],
                    'quantity' => $item->quantity, // Quantity from $checkout array
                ];
            }
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));
        $session = $stripe->checkout->sessions->create([
            'success_url' => route('checkout-success')."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout-cancel'),
            'line_items' => $lineItems,
            'mode' => 'payment',
        ]);

        $order = new Order();
        $order->session_id = $session->id;
        $order->is_paid = false;
        $order->total_price = $totalPrice;
        $order->buyers_user_id = Auth::user()->id;
        $order->save();

        return redirect($session->url);
    }
}