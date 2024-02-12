<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Log;
use App\Models\ShoppingList;
use App\Models\Seller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{

    public function connectStripe()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));

        $accountLink = $stripe->accountLinks->create([
            'account' => Seller::where('user_id', Auth::user()->id)->first()->account_id,
            'refresh_url' => route('refresh-stripe'),
            'return_url' => route('return-stripe'),
            'type' => 'account_onboarding',
        ]);

        return redirect($accountLink->url);
    }

    public function shopping()
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $products = Product::all();

        return view('buyer.index', ['products' => $products]);
    }

    public function shoppingKeyWord(Request $request)
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $keyWord = $request->keyWord;

        $products = Product::where(function ($query) use ($keyWord) {
            $query->where('name', 'like', "%$keyWord%");
        })->get();

        return view('buyer.index', ['products' => $products]);
    }

    public function shoppingCart()
    {
        $user = Auth::user();

        if ($user->type !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
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

        return view('buyer.shopping-cart', [
            'products' => $products,
            'sum' => $sum
        ]);
    }

    public function previousPurchases()
    {
        $user = Auth::user();
        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $orders = Order::where('buyers_user_id', $user->id)->orderBy('is_paid')->pluck('id');

        $logs = Log::whereIn('order_id', $orders)->get();

        $ordersList = Order::where('buyers_user_id', $user->id)->orderBy('is_paid')->get();


        return view('buyer.previous-purchases', ['orders' => $ordersList, 'logs' => $logs]);
    }

    public function sellerDashboard()
    {
        $user = Auth::user();
        $userId = $user->id;
        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Seller') {
            return redirect()->route('shopping');
        }

        $products = Product::where('seller_user_id', $userId)->get();

        return view('seller.index', ['products' => $products, 'seller' => Seller::where('user_id', $userId)->first()]);
    }

    public function sells()
    {
        $user = Auth::user();
        $userId = $user->id;
        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Seller') {
            abort(404); // If type is not 'Seller', return a 404 not found error
        }

        $logs = Log::where('sellers_user_id', $userId)->where('is_paid', true)->orderBy('created_at', 'desc')->get();

        return view('seller.sells', ['logs' => $logs]);
    }

    public function stats()
    {
        $user = Auth::user();
        $userId = $user->id;
        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Seller') {
            abort(404); // If type is not 'Seller', return a 404 not found error
        }

        $dateLogs = Log::where('user_id', $userId)->get();

        // Initialize an empty array to store summed prices for each date
        $summedPrices = [];

        // Iterate over the logs
        foreach ($dateLogs as $log) {
            $date = $log->date;
            $price = $log->price;

            // If the date is not already in the summedPrices array, initialize it with the current price
            if (!isset($summedPrices[$date])) {
                $summedPrices[$date] = $price;
            } else {
                // If the date already exists, add the current price to the existing sum
                $summedPrices[$date] += $price;
            }
        }

        $totalIncome = 0;

        return view('seller.stats', ['dateLogs' => $dateLogs, 'totalIncome' => $totalIncome]);
    }

    public function newProduct()
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Seller') {
            abort(404); // If type is not 'Seller', return a 404 not found error
        }

        return view('seller.new-product');
    }

    public function editProduct($product_id)
    {
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Seller') {
            abort(404); // If type is not 'Seller', return a 404 not found error
        }

        $product = Product::where('id', $product_id)->first();

        return view('seller.edit-product', ['product' => $product]);
    }

    public function returnStripe()
    {
        $seller = Seller::where('user_id', Auth::user()->id)->first();

        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));
        $account = $stripe->accounts->retrieve($seller->account_id, []);

        if ($account->charges_enabled) {
            $seller->is_test = false;
            $seller->save();
            return PageController::sellerDashboard();
        } else {
            $seller->is_test = true;
            $seller->save();
            return PageController::sellerDashboard();
        }
    }

    public function refreshStripe()
    {
        return PageController::sellerDashboard();
    }

    public function checkoutSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));

        $session = $stripe->checkout->sessions->retrieve($sessionId, []);

        if (!$session) {
            throw new NotFoundHttpException();
        }

        $order = Order::where('session_id', $session->id)->first();

        if (!$order) {
            throw new NotFoundHttpException();
        }

        if (!$order->is_paid) {
            $order->is_paid = true;
            $order->save();
        }

        return view('buyer.checkout-success', ['session' => $session]);
    }

    public function checkoutCancel(Request $request)
    {
        $sessionId = $request->get('session_id');

        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));

        $session = $stripe->checkout->sessions->retrieve($sessionId, []);

        if (!$session) {
            throw new NotFoundHttpException();
        }

        $lists = ShoppingList::where('buyers_user_id', Auth::user()->id)->get();

        foreach ($lists as $list){
            $list->delete();
        }

        $order = Order::where('session_id', $session->id)->first();

        return view('buyer.checkout-cancel', ['orderId' => $order->id]);
    }

    public function editOrder($orderId)
    {
        //TODO redirect to new page to edit page (like shopping cart)
        $logs = Log::where('order_id', $orderId)->get();

        $sum = Order::where('id', $orderId)->get()->first()->total_price;
        
        return view('buyer.edit-order', ['logs' => $logs, 'orderId' => $orderId, 'sum' => $sum]);
    }
}
