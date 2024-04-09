<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Log;
use App\Models\ShoppingList;
use App\Models\Seller;
use App\Models\Order;
use App\Models\User;
use App\Models\Appeal;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    // Admin routes functions

    public function products()
    {

        if (!Auth::user()->is_admin) {
            abort(404);
        }

        $products = Product::all();
        return view('administrator.index', ['products' => $products]);
    }

    public function users()
    {

        if (!Auth::user()->is_admin) {
            abort(404);
        }

        $users = User::all()->where('is_admin', false);

        return view('administrator.users', ['users' => $users]);
    }

    public function appeals()
    {
        if (!Auth::user()->is_admin) {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $appeals = Appeal::all();

        return view('administrator.appeals', ['appeals' => $appeals]);
    }

    public function searchAppeals(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $keyWord = $request->keyWord;

        $users = Appeal::where(function ($query) use ($keyWord) {
            $query->where('name', 'like', "%$keyWord%");
        })->get();

        return view('administrator.appeals', ['appeals' => $users]);
    }

    public function searchAccount(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $keyWord = $request->keyWord;

        $users = User::where(function ($query) use ($keyWord) {
            $query->where('name', 'like', "%$keyWord%");
        })->get();

        return view('administrator.users', ['users' => $users]);
    }
    // 

    public function accountDeleted($userId)
    {
        $appeal = Appeal::where('user_id', $userId)->get();
        $firstAppeal = count($appeal) == 0;
        return view('account-deleted', ['firstAppeal' => $firstAppeal]);
    }

    public function appealing(Request $request, $userId)
    {

        $text = $request->text;

        $appeal = new Appeal();
        $appeal->user_id = $userId;
        $appeal->text = $text;
        $appeal->name = User::find($userId)->name;
        $appeal->save();

        return redirect()->route('account-deleted', $userId);
    }

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

    public function profile()
    {
        if (Auth::user()->is_deleted) {
            return redirect()->route('account-deleted', Auth::user()->id);
        }
        return view('profile.show');
    }

    public function shopping()
    {
        $typeOfAccount = Auth::user()->type;
        if (Auth::user()->is_deleted) {
            return redirect()->route('account-deleted', Auth::user()->id);
        }

        if ($typeOfAccount == 'Seller') {
            return redirect()->route('dashboard');
        } else if ($typeOfAccount == 'Admin') {
            abort(404); // If type is 'Admin', return a 404 not found error
        }

        $products = Product::all()->where('is_deleted', false);
        $categories = Category::all()->where('is_accepted', true)->sortBy('name');

        return view('buyer.index', ['products' => $products, 'title' => "Пазаруване", 'categories' => $categories, 'categoriesFilter' => null]);
    }

    public function shoppingCategory($category)
    {
        $typeOfAccount = Auth::user()->type;
        if (Auth::user()->is_deleted) {
            return redirect()->route('account-deleted', Auth::user()->id);
        }

        if ($typeOfAccount == 'Seller') {
            return redirect()->route('dashboard');
        } else if ($typeOfAccount == 'Admin') {
            abort(404); // If type is 'Admin', return a 404 not found error
        }
        $category = Category::where('name', $category)->first();
        $products = $category->products()->where('is_deleted', false);
        $categories = Category::all()->where('is_accepted', true)->sortBy('name');

        return view('buyer.index', ['products' => $products, 'title' => "Пазаруване", 'categories' => $categories, 'categoriesFilter' => null]);
    }

    public function shoppingFilters(Request $request)
    {
        $typeOfAccount = Auth::user()->type;
        if (Auth::user()->is_deleted) {
            return redirect()->route('account-deleted', Auth::user()->id);
        }

        if ($typeOfAccount == 'Seller') {
            return redirect()->route('dashboard');
        } else if ($typeOfAccount == 'Admin') {
            abort(404); // If type is 'Admin', return a 404 not found error
        }

        $priceFrom = $request->input('price-from');
        $priceTo = $request->input('price-to');
        $rating = $request->input('rating');

        $query = Product::query();


        if ($priceFrom && $priceTo) {
            $query->whereBetween('price', [$priceFrom, $priceTo]);
        }

        $filteredProducts = $query->get();

        $categories = Category::all()->where('is_accepted', true)->sortBy('name');

        if ($priceFrom) {
            return view('buyer.index', ['products' => $filteredProducts, 'title' => "Пазаруване", 'categories' => $categories, 'priceFrom' => $priceFrom, 'priceTo' => $priceTo]);
        }
        return view('buyer.index', ['products' => $filteredProducts, 'title' => "Пазаруване", 'categories' => $categories, 'categoriesFilter' => null]);
    }

    public function completeOrderCart()
    {
        $user = Auth::user();
        if ($user->is_deleted) {
            return redirect()->route('account-deleted', $user->id);
        }

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

        return view('buyer.complete-order', [
            'products' => $products,
            'sum' => $sum,
            'title' => "Количка"
        ]);
    }

    public function shoppingKeyWord(Request $request)
    {
        $typeOfAccount = Auth::user()->type;
        if (Auth::user()->is_deleted) {
            return redirect()->route('account-deleted', Auth::user()->id);
        }

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $keyWord = $request->keyWord;

        $products = Product::where(function ($query) use ($keyWord) {
            $query->where('name', 'like', "%$keyWord%");
        })->get();

        $categories = Category::all()->where('is_accepted', true)->sortBy('name');

        return view('buyer.index', ['products' => $products, 'title' => "Пазаруване", 'categories' => $categories, 'categoriesFilter' => null]);
    }

    public function shoppingCart()
    {
        $user = Auth::user();
        if ($user->is_deleted) {
            return redirect()->route('account-deleted', $user->id);
        }

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
            'sum' => $sum,
            'title' => "Количка"
        ]);
    }

    public function previousPurchases()
    {
        $user = Auth::user();
        if ($user->is_deleted) {
            return redirect()->route('account-deleted', $user->id);
        }
        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Buyer') {
            abort(404); // If type is not 'Buyer', return a 404 not found error
        }

        $orders = Order::where('buyers_user_id', $user->id)->orderBy('is_paid')->pluck('id');

        $logs = Log::whereIn('order_id', $orders)->get();

        $ordersList = Order::where('buyers_user_id', $user->id)->orderBy('is_paid')->get();


        return view('buyer.previous-purchases', ['orders' => $ordersList, 'logs' => $logs, 'title' => "Минали покупки"]);
    }

    public function billingAddresses()
    {
        $user = Auth()->user();
        if ($user->is_deleted) {
            return redirect()->route('account-deleted', $user->id);
        }
        $addresses = $user->billingAddresses();

        return view('buyer.billing-addresses', ['addresses' => $addresses]);
    }

    public function sellerDashboard()
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($user->is_deleted) {
            return redirect()->route('account-deleted', $userId);
        }

        $typeOfAccount = $user->type;

        if ($typeOfAccount == 'Buyer') {
            return redirect()->route('shopping');
        } else if ($typeOfAccount == 'Admin') {
            return redirect()->route('products');
        }


        $products = Product::where('seller_user_id', $userId)->get();
        $categories = Category::all()->where('is_accepted', true)->sortBy('name');


        return view('seller.index', [
            'products' => $products,
            'seller' => Seller::where('user_id', $userId)->first(),
            'title' => "Продукти",
            'categories' => $categories
        ]);
    }

    public function sells()
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($user->is_deleted) {
            return redirect()->route('account-deleted', $userId);
        }

        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Seller') {
            abort(404);
        }

        // Step 1: Retrieve logs for the seller
        $logs = Log::where('sellers_user_id', $userId)->where('is_paid', true)->orderBy('created_at')->get();

        // Step 2: Group logs by order_id
        $groupedLogs = $logs->groupBy('order_id');

        // Step 3 & 4: Process each order
        $formattedOrders = [];
        foreach ($groupedLogs as $orderId => $logsForOrder) {
            $order = Order::find($orderId);
            // Retrieve buyer information
            $buyer = User::find($order->buyers_user_id);

            // Calculate total amount per order
            $totalAmount = 0;
            $products = [];

            foreach ($logsForOrder as $log) {
                $product = Product::find($log->product);
                $totalAmount += $product->price * $log->quantity;
                $products[] = [
                    'product_id' => $product->id,
                    'quantity' => $log->quantity,
                    'total_price' => $product->price * $log->quantity,
                ];
            }

            // Format order information
            $formattedOrders[] = [
                'order' => $order,
                'buyer' => $buyer,
                'total_amount' => $totalAmount,
                'products' => $products,
            ];
        }

        return view('seller.sells', ['formattedOrders' => $formattedOrders, 'title' => "Продажби"]);
    }

    public function stats()
    {
        $user = Auth::user();
        $userId = $user->id;
        if ($user->is_deleted) {
            return redirect()->route('account-deleted', $userId);
        }
        $typeOfAccount = $user->type;

        if ($typeOfAccount !== 'Seller') {
            abort(404); // If type is not 'Seller', return a 404 not found error
        }

        $dateLogs = Log::where('sellers_user_id', $userId)->get();

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

        return view('seller.stats', ['dateLogs' => $dateLogs, 'totalIncome' => $totalIncome, 'title' => "Статистики"]);
    }

    public function editProduct($product_id)
    {
        if (Auth::user()->is_deleted) {
            return redirect()->route('account-deleted', Auth::user()->id);
        }
        $typeOfAccount = Auth::user()->type;

        if ($typeOfAccount !== 'Seller') {
            abort(404); // If type is not 'Seller', return a 404 not found error
        }

        $product = Product::where('id', $product_id)->first();

        return view('seller.edit-product', ['product' => $product, 'title' => "Поправи продукт"]);
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
            // Check if the session is actually paid
            if ($session->payment_status === 'paid') {
                $order->is_paid = true;
                $order->save();

                // Empty the cart
                ShoppingList::where('buyers_user_id', optional(Auth::user())->id)->delete();
            } elseif ($session->payment_status === 'unpaid') {
                return redirect()->route('checkout-cancel', ['session_id' => $session->id]);
            }
        }

        return view('buyer.checkout-success', ['session' => $session, 'title' => "Успешна покупка"]);
    }

    public function checkoutCancel(Request $request)
    {
        $sessionId = $request->get('session_id');

        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));

        $session = $stripe->checkout->sessions->retrieve($sessionId, []);

        if (!$session) {
            throw new NotFoundHttpException();
        }

        $lists = ShoppingList::where('buyers_user_id', optional(Auth::user())->id)->get();

        foreach ($lists as $list) {
            $list->delete();
        }

        $order = Order::where('session_id', $session->id)->first();

        return view('buyer.checkout-cancel', ['orderId' => optional($order)->id, 'title' => "Неуспешна покупка"]);
    }

    public function editOrder($orderId)
    {
        if (Auth::user()->is_deleted) {
            return redirect()->route('account-deleted', Auth::user()->id);
        }
        $logs = Log::where('order_id', $orderId)->get();

        $order = Order::find($orderId);

        $sum = $order->total_price;


        return view('buyer.edit-order', ['logs' => $logs, 'order' => $order, 'sum' => $sum, 'title' => "Поправи поръчка"]);
    }
}
