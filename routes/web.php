<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountSwitchController;
use App\Http\Controllers\Api\V1\ShoppingListController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Api\V1\ProductController;

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

// Routes with verification
Route::middleware(['auth:sanctum', 'verified'])->group(function () {


    Route::get('/shopping', [PageController::class, 'shopping'])->name('shopping');
    Route::get('/shopping-cart', [PageController::class, 'shoppingCart'])->name('shopping-cart');
    Route::get('/previous-purchases', [PageController::class, 'previousPurchases'])->name('previous-purchases');
    Route::get('/dashboard', [PageController::class, 'sellerDashboard'])->name('dashboard');
    Route::get('/sells', [PageController::class, 'sells'])->name('sells');
    Route::get('/new-product', [PageController::class, 'newProduct'])->name('new-product');
    Route::post('/new-product', [ProductController::class, 'store'])->name('new-product');


    Route::get('/get-session-message', function () {
        return response()->json(['success' => Session::get('success')]);
    });


    Route::post('/switch-account', [AccountSwitchController::class, 'switchAccount'])->name('switch.account');
    Route::post('/add-to-cart', [ShoppingListController::class, 'addToShoppingList'])->name('add-to-cart');
    Route::post('/edit-shopping-quantity', [ShoppingListController::class, 'editShoppingQuantity'])->name('edit-shopping-quantity');
    Route::post('/edit-product', [ProductController::class, 'edit'])->name('edit-product');

    Route::get('/remove-product-from-cart', [ShoppingListController::class, 'removeProduct']);
    Route::get('/search', [PageController::class, 'shoppingKeyWord']);
});

