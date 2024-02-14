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
    Route::get('/shopping-cart', [PageController::class, 'shoppingCart'])->name('shopping-cart');
    Route::get('/previous-purchases', [PageController::class, 'previousPurchases'])->name('previous-purchases');
    Route::get('/dashboard', [PageController::class, 'sellerDashboard'])->name('dashboard');
    Route::get('/sells', [PageController::class, 'sells'])->name('sells');
    Route::get('/new-product', [PageController::class, 'newProduct'])->name('new-product');
    Route::get('/edit-product/{product_id}', [PageController::class, 'editProduct'])->name('edit-product');
    Route::get('/stats', [PageController::class, 'stats'])->name('stats');
    Route::get('/connect-stripe', [PageController::class, 'connectStripe'])->name('connect-stripe');
    Route::get('/refresh-stripe', [PageController::class, 'refreshStripe'])->name('refresh-stripe');
    Route::get('/return-stripe', [PageController::class, 'returnStripe'])->name('return-stripe');
    // Route::get('/checkout-success', [PageController::class, 'checkoutSuccess'])->name('checkout-success');
    // Route::get('/checkout-cancel', [PageController::class, 'checkoutCancel'])->name('checkout-cancel');
    Route::get('/edit-order/{order_id}', [PageController::class, 'editOrder'])->name('edit-order');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');


    Route::get('/get-session-message', function () {
        return response()->json(['success' => Session::get('success')]);
    });


    Route::post('/new-product', [ProductController::class, 'store'])->name('new-product-add');
    Route::post('/switch-account', [AccountSwitchController::class, 'switchAccount'])->name('switch.account');
    Route::post('/add-to-cart', [ShoppingListController::class, 'addToShoppingList'])->name('add-to-cart');
    Route::post('/edit-shopping-quantity', [ShoppingListController::class, 'editShoppingQuantity'])->name('edit-shopping-quantity');
    Route::post('/edit-product', [ProductController::class, 'edit'])->name('edit-product-save');
    Route::post('/change-status/{product_id}/{status}', [ProductController::class, 'changeStatus'])->name('change-status');
    Route::post('/complete-order', [BuyerController::class, 'completeOrder'])->name('complete-order');
    Route::post('/pay-order/{order_id}', [BuyerController::class, 'payOrder'])->name('pay-order');
    Route::post('/edit-order-save/{order_id}', [OrderController::class, 'editOrder'])->name('edit-order-save');
    Route::post('/edit-log/{log_id}/{new_quantity}', [LogController::class, 'editQuantity'])->name('edit-log');
    Route::post('/delete-order/{order_id}', [OrderController::class, 'destroy'])->name('delete-order');
    Route::post('/delete-log/{log_id}', [LogController::class, 'destroy'])->name('delete-log');
    Route::post('/update-full-name/{order_id}/{new_quantity}', [OrderController::class, 'updateFullName'])->name('update-full-name');
    Route::post('/update-phone/{order_id}/{new_quantity}', [OrderController::class, 'updatePhone'])->name('update-phone');
    Route::post('/update-address/{order_id}/{new_quantity}', [OrderController::class, 'updateAddress'])->name('update-address');
    Route::post('/remove-product-from-cart/{product_id}', [ShoppingListController::class, 'removeProduct'])->name('remove-product-from-cart');

    Route::get('/search', [PageController::class, 'shoppingKeyWord']);
});
Route::post('/webhook', [WebhookController::class, 'checkoutWebhook'])->name('webhook');
