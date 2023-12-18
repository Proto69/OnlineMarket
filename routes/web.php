<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountSwitchController;
use App\Http\Controllers\Api\V1\ShoppingListController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Session;

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
});

// Routes with verification
Route::middleware(['auth:sanctum', 'verified'])->group(function () {


    Route::get('/shopping', [PageController::class, 'shopping'])->name('shopping');
    Route::get('/shopping-cart', [PageController::class, 'shoppingCart'])->name('shopping-cart');
    Route::get('/previous-purchases', [PageController::class, 'previousPurchases'])->name('previous-purchases');
    Route::get('/dashboard', [PageController::class, 'sellerDashboard'])->name('dashboard');
    Route::get('/sells', [PageController::class, 'sells'])->name('sells');


    Route::get('/get-session-message', function () {
        return response()->json(['success' => Session::get('success')]);
    });


    Route::post('/switch-account', [AccountSwitchController::class, 'switchAccount'])->name('switch.account');
    Route::post('/add-to-cart', [ShoppingListController::class, 'addToShoppingList'])->name('add-to-cart');
    Route::post('/edit-quantity', [ShoppingListController::class, 'editQuantity'])->name('edit-quantity');

    Route::get('/remove-product-from-cart', [ShoppingListController::class, 'removeProduct']);
    Route::get('/search', [PageController::class, 'shoppingKeyWord']);
});

