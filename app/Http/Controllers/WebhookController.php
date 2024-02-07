<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShoppingList;


class WebhookController extends Controller
{

    public function checkoutWebhook()
    {


        // The library needs to be configured with your account's secret key.
        // Ensure the key is kept out of any version control system you might be using.
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

                ShoppingList::where('buyers_user_id', $order->user_id)->delete();


            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);
    }
}
