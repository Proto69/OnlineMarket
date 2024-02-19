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
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function completeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => __('Полето за пълно име е задължително.'),
            'full_name.string' => __('Пълното име трябва да бъде текст.'),
            'full_name.max' => __('Пълното име трябва да е максимум :max знака.'),
            'phone.required' => __('Полето за телефон е задължително.'),
            'phone.string' => __('Телефонният номер трябва да бъде текст.'),
            'phone.max' => __('Телефонният номер трябва да е максимум :max знака.'),
            'address.required' => __('Полето за адрес е задължително.'),
            'address.string' => __('Адресът трябва да бъде текст.'),
            'address.max' => __('Адресът трябва да е максимум :max знака.'),
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        $fullName = $request->input('full_name');
        $phone = $request->input('phone');
        $address = $request->input('address');

        $shoppingCart = ShoppingList::where('buyers_user_id', Auth::user()->id)->get();

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
            'success_url' => route('checkout-success') . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout-cancel') . "?session_id={CHECKOUT_SESSION_ID}",
            'line_items' => $lineItems,
            'mode' => 'payment',
        ]);

        $order = new Order();
        $order->session_id = $session->id;
        $order->is_paid = false;
        $order->total_price = $totalPrice;
        $order->buyers_user_id = Auth::user()->id;
        $order->full_name = $fullName;
        $order->phone = $phone;
        $order->address = $address;
        $order->save();

        $order = Order::where('session_id', $session->id)->first();

        foreach ($shoppingCart as $item) {
            $product = Product::where('id', $item->products_id)->first();

            // Adding log
            $log = new Log();
            $log->order_id = $order->id;
            $log->product = $product->id;
            $log->quantity = $item->quantity;
            $log->sellers_user_id = $product->seller_user_id;
            $log->is_paid = false;

            $log->save();
        }

        return redirect($session->url);
    }

    public function payOrder($orderId)
    {
        $order = Order::find($orderId);
        $logs = Log::where('order_id', $orderId)->get();
        $totalPrice = 0;

        foreach ($logs as $item) {

            $product = Product::where('id', $item->product)->first();

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
            'success_url' => route('checkout-success') . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout-cancel') . "?session_id={CHECKOUT_SESSION_ID}",
            'line_items' => $lineItems,
            'mode' => 'payment',
        ]);

        $order->session_id = $session->id;
        $order->save();

        return redirect($session->url);
    }
}
