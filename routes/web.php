<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountSwitchController;
use App\Http\Controllers\Api\V1\ShoppingListController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\BuyerController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\LogController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BillingAddressController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Models\BillingAddress;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/checkout-success', [PageController::class, 'checkoutSuccess'])->name('checkout-success');
Route::get('/checkout-cancel', [PageController::class, 'checkoutCancel'])->name('checkout-cancel');

// Routes with verification
Route::middleware(['auth:sanctum', 'verified'])->group(function () {


    Route::get('/shopping', [PageController::class, 'shopping'])->name('shopping');
    Route::get('/shopping/{category}', [PageController::class, 'shoppingCategory'])->name('shopping-category');
    Route::get('/shopping-filters', [PageController::class, 'shoppingFilters'])->name('shopping-filters');
    Route::get('/shopping-cart', [PageController::class, 'shoppingCart'])->name('shopping-cart');
    Route::get('/previous-purchases', [PageController::class, 'previousPurchases'])->name('previous-purchases');
    Route::get('/billing-addresses', [PageController::class, 'billingAddresses'])->name('billing-addresses');
    Route::get('/complete-order-cart', [PageController::class, 'completeOrderCart'])->name('complete-order-cart');
    Route::get('/dashboard', [PageController::class, 'sellerDashboard'])->name('dashboard');
    Route::get('/sells', [PageController::class, 'sells'])->name('sells');
    // Working on it
    Route::get('/stats', [PageController::class, 'stats'])->name('stats');
    //
    Route::get('/connect-stripe', [PageController::class, 'connectStripe'])->name('connect-stripe');
    Route::get('/refresh-stripe', [PageController::class, 'refreshStripe'])->name('refresh-stripe');
    Route::get('/return-stripe', [PageController::class, 'returnStripe'])->name('return-stripe');
    Route::get('/edit-order/{order_id}', [PageController::class, 'editOrder'])->name('edit-order');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::get('/account-deleted/{user_id}', [PageController::class, 'accountDeleted'])->name('account-deleted');

    // Admin routes
    Route::get('/products', [PageController::class, 'products'])->name('products');
    Route::get('/users', [PageController::class, 'users'])->name('users');
    Route::get('/comments', [PageController::class, 'comments'])->name('comments');
    Route::get('/search-account', [PageController::class, 'searchAccount'])->name('search-account');
    Route::get('/appeals', [PageController::class, 'appeals'])->name('appeals');
    Route::get('/search-appeals', [PageController::class, 'searchAppeals'])->name('search-appeals');
    Route::post('/deactivate-product-admin/{product_id}', [AdminController::class, 'deactivateProduct'])->name('deactivate-product-admin');
    Route::post('/deactivate-account-admin/{user_id}', [AdminController::class, 'deactivateAccount'])->name('deactivate-account-admin');
    Route::post('/deactivate-comment-admin/{comment_id}', [AdminController::class, 'deactivateComment'])->name('deactivate-comment-admin');
    Route::post('/activate-product-admin/{product_id}', [AdminController::class, 'activateProduct'])->name('activate-product-admin');
    Route::post('/activate-account-admin/{user_id}', [AdminController::class, 'activateAccount'])->name('activate-account-admin');
    Route::post('/activate-comment-admin/{comment_id}', [AdminController::class, 'activateComment'])->name('activate-comment-admin');



    Route::get('/get-session-message', function () {
        return response()->json(['success' => Session::get('success')]);
    });


    Route::post('/new-product', [ProductController::class, 'store'])->name('new-product-add');
    Route::post('/switch-account', [AccountSwitchController::class, 'switchAccount'])->name('switch.account');
    Route::post('/add-to-cart', [ShoppingListController::class, 'addToShoppingList'])->name('add-to-cart');
    Route::post('/add-to-cart-quantity/{product_id}', [ShoppingListController::class, 'addToShoppingListQuantity'])->name('add-to-cart-quantity');
    Route::post('/edit-shopping-quantity', [ShoppingListController::class, 'editShoppingQuantity'])->name('edit-shopping-quantity');
    Route::post('/edit-product/{product_id}', [ProductController::class, 'edit'])->name('edit-product-save');
    Route::post('/change-status/{product_id}/{status}', [ProductController::class, 'changeStatus'])->name('change-status');
    Route::post('/complete-order', [BuyerController::class, 'completeOrder'])->name('complete-order');
    Route::post('/pay-order/{order_id}', [BuyerController::class, 'payOrder'])->name('pay-order');
    Route::post('/edit-order-save/{order_id}', [OrderController::class, 'editOrder'])->name('edit-order-save');
    Route::post('/edit-log/{log_id}/{new_quantity}', [LogController::class, 'editQuantity'])->name('edit-log');
    Route::post('/edit-billing-address/{billingAddress_id}', [BillingAddressController::class, 'editBillingAddress'])->name('edit-billing-address');
    Route::post('/delete-order/{order_id}', [OrderController::class, 'destroy'])->name('delete-order');
    Route::post('/delete-billingAddress/{billingAddress_id}', [BillingAddressController::class, 'destroy'])->name('delete-billing-address');
    Route::post('/delete-log/{log_id}', [LogController::class, 'destroy'])->name('delete-log');
    Route::post('/update-full-name/{order_id}/{new_quantity}', [OrderController::class, 'updateFullName'])->name('update-full-name');
    Route::post('/update-phone/{order_id}/{new_quantity}', [OrderController::class, 'updatePhone'])->name('update-phone');
    Route::post('/update-address/{order_id}/{new_quantity}', [OrderController::class, 'updateAddress'])->name('update-address');
    Route::post('/remove-product-from-cart/{product_id}', [ShoppingListController::class, 'removeProduct'])->name('remove-product-from-cart');
    Route::post('/appealing/{user_id}', [PageController::class, 'appealing'])->name('appealing');
    Route::post('/mark-order-as-sent/{order_id}', [OrderController::class, 'orderSent'])->name('mark-order-as-sent');
    Route::post('/mark-order-as-delivered/{order_id}', [OrderController::class, 'orderDelivered'])->name('mark-order-as-delivered');
    Route::post('/mark-log-as-delivered/{log_id}', [OrderController::class, 'logDelivered'])->name('mark-log-as-delivered');
    Route::post('/new-address', [BillingAddressController::class, 'store'])->name('new-address');
    Route::post('/new-comment/{product_id}', [CommentController::class, 'store'])->name('new-comment');

    Route::get('/search', [PageController::class, 'shoppingKeyWord']);
});

Route::post('/webhook', [WebhookController::class, 'checkoutWebhook'])->name('webhook');
// For testing email
Route::get('/test', [OrderController::class, 'test'])->name('test');