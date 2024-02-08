<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShoppingList;
use App\Models\Product;
use App\Models\Seller;


class WebhookController extends Controller
{

    public function checkoutWebhook()
    {
        $stripe = new \Stripe\StripeClient('STRIPE_KEY');

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_ENDPOINT_SECCRET_CHECKOUT');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $order = Order::where('session_id', $session->id)->first();
                if ($order && !$order->is_paid) {
                    $order->is_paid = true;
                    $order->save();
                }

                $shoppingItems = ShoppingList::where('buyers_user_id', $order->user_id)->get();

                foreach ($shoppingItems as $item) {
                    $productId = $item->products_id;

                    // FIXME: not changing product quantity
                    $product = Product::find($productId);

                    $product->bought_quantity += $item->quantity;
                    $product->quantity -= $item->quantity;

                    if ($product->quantity == 0) {
                        $product->active = false;
                    }

                    $product->save();

                    $seller = Seller::find($product->seller_user_id);

                    $seller->balance += $product->price * $item->quantity;

                    if ($seller->is_test) {
                        $stripe->transfers->create([
                            'amount' => $product->price * $item->quantity * 100,
                            'currency' => 'bgn',
                            'destination' => env('STRIPE_DEFAULT_ACCOUNT')
                        ]);
                    } else {
                        $stripe->transfers->create([
                            'amount' => $product->price * $item->quantity * 100,
                            'currency' => 'bgn',
                            'destination' => $seller->account_id
                        ]);
                    }

                    $seller->save();

                    // TODO: add logs to the database

                    $item->delete();
                }

                // TODO: send email to the user


            default:
                echo 'Непознат евент' . $event->type;
        }

        return response('', 200);
    }
}
