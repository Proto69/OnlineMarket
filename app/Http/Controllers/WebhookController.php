<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShoppingList;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessful;
use Illuminate\Support\Facades\Auth;
use App\Mail\SellerNewOrder;

class WebhookController extends Controller
{

    public function checkoutWebhook()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_ENDPOINT_SECRET_CHECKOUT');

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

                $shoppingItems = ShoppingList::where('buyers_user_id', $order->buyers_user_id)->get();

                foreach ($shoppingItems as $item) {
                    $productId = $item->products_id;

                    $product = Product::find($productId);

                    $product->bought_quantity += $item->quantity;
                    $product->quantity -= $item->quantity;

                    if ($product->quantity == 0) {
                        $product->active = false;
                    }

                    $product->save();


                    $seller = Seller::find($product->seller_user_id);

                    $amount_to_pay = ($product->price - (0.07 * $product->price)) * $item->quantity;
                    $amount_in_cents =  (int) ($amount_to_pay * 100);

                    $seller->balance += $amount_to_pay;

                    if ($seller->is_test) {
                        $stripe->transfers->create([
                            'amount' => $amount_in_cents,
                            'currency' => 'bgn',
                            'destination' => env('STRIPE_DEFAULT_ACCOUNT')
                        ]);
                    } else {
                        $stripe->transfers->create([
                            'amount' => $amount_in_cents,
                            'currency' => 'bgn',
                            'destination' => $seller->account_id
                        ]);
                    }

                    $seller->save();



                    $item->delete();
                }

                $logs = Log::where('order_id', $order->id)->get();

                foreach ($logs as $log) {
                    $log->is_paid = true;
                    $log->save();
                }

                Mail::to(Auth::user())->send(new OrderSuccessful($order, $logs));
                
                $userIds = $logs->pluck('user_id')->unique();

                foreach ($userIds as $userId) {
                    // FIXME: not all products
                    Mail::to(User::find($userId))->send(new SellerNewOrder($order));
                }

                return response('Потвърдена и завършена поръчка!', 200);

            default:
                return response('Непознат евент ' + $event->type, 404);
        }

        return response(' ');
    }
}
