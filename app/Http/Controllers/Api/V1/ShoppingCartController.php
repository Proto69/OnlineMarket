<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Log;

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

    public function completeOrder()
    {
        $user = Auth::user();
        $shoppingCart = ShoppingList::where('buyers_user_id', $user->id)->get();
        $productIds = $shoppingCart->pluck('products_id')->toArray();
        $products = Product::whereIn('id', $productIds)->get();

        $lineItems = [];
        $totalPrice = 0;

        foreach ($shoppingCart as $item) {
            $product = $products->firstWhere('id', $item->products_id);

            if ($product) {
                $totalPrice += $product->price * $item->quantity;

                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'bgn',
                        'product_data' => [
                            'name' => $product->name,
                        ],
                        'unit_amount' => $product->price * 100,
                    ],
                    'quantity' => $item->quantity,
                ];
            }
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));
        $session = $stripe->checkout->sessions->create([
            'success_url' => route('app.checkout-success') . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout-cancel') . "?session_id={CHECKOUT_SESSION_ID}",
            'line_items' => $lineItems,
            'mode' => 'payment',
        ]);

        $order = new Order();
        $order->session_id = $session->id;
        $order->is_paid = false;
        $order->total_price = $totalPrice;
        $order->user_id = Auth::user()->id;
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

        return response()->json(['payment_url' => $session->url], 200);
    }

    public function checkoutSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId, []);

            if (!$session) {
                return response()->json(['message' => 'Плащането не е намерено'], 400);
            }

            $order = Order::where('session_id', $session->id)->first();
            if (!$order) {
                return response()->json(['message' => 'Плащането не е намерено'], 400);
            }
            if (!$order->is_paid) {
                $order->is_paid = true;
                $order->save();
            }

            return response()->json(['message' => 'Плащането е успешно'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Получена е грешка при плащането.'], 400);
        }
    }

    public function checkoutCancel()
    {
        return response()->json(['message' => 'Плащането е отказано'], 200);
    }

    public function removeFromCart(Request $request)
    {
        $user = Auth::user();

        $shoppingItem = ShoppingList::where('buyers_user_id', $user->id)
            ->where('products_id', $request->product_id)
            ->first();

        if ($shoppingItem) {
            $shoppingItem->delete();
            return response()->json(['message' => 'Продуктът е премахнат от количката'], 200);
        }

        return response()->json(['error' => 'Продуктът не е намерен в количката'], 404);
    }
}
