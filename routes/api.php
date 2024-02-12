<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\ShoppingListController;
use App\Http\Controllers\Api\V1\ShoppingCartController;
use App\Http\Controllers\Api\V1\SellerController;
use App\Http\Controllers\Api\V1\ProfileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('app/v1')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('app.login');
    // Route::get('checkout-success', [ShoppingCartController::class, 'checkoutSuccess'])->name('app.checkout-success');
    // Route::get('checkout-cancel', [ShoppingCartController::class, 'checkoutCancel'])->name('app.checkout-cancel');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('v1')->group(function () {
        // Route::apiResource('products', ProductController::class);
        // Route::post('login', [LoginController::class, 'login']);
    });

    Route::prefix('app/v1')->group(function () {
        Route::post('validate', [LoginController::class, 'validateToken'])->name('app.validate-token');
        Route::post('add-to-cart', [ShoppingListController::class, 'addToShoppingList'])->name('app.add-to-cart');
        Route::post('edit-product', [SellerController::class, 'updateProduct'])->name('app.edit-product');
        Route::post('change-type', [LoginController::class, 'changeMyType'])->name('app.change-type');
        Route::post('delete-product/{product_id}', [SellerController::class, 'destroy'])->name('app.product-delete');
        Route::post('complete-order', [ShoppingCartController::class, 'completeOrder'])->name('app.checkout');
        Route::put('profile', [ProfileController::class, 'update'])->name('app.profile-update');
        Route::post('remove-from-cart/{product_id}', [ShoppingCartController::class, 'removeFromCart'])->name('app.remove-from-cart');
        Route::post('add-product', [SellerController::class, 'createProduct'])->name('app.add-product');
        Route::post('logout', [LoginController::class, 'logout'])->name('app.logout');

        Route::prefix('fetch') -> group(function () {
            Route::get('products', [ProductController::class, 'listAllAvailableProducts'])->name('app.products');
            Route::get('cart', [ShoppingCartController::class, 'cart'])->name('app.cart');
            Route::get('edit-product/{product_id}', [SellerController::class, 'edit'])->name('app.seller-edit');
            Route::get('dashboard', [SellerController::class, 'dash'])->name('app.seller-dash');
            Route::get('type', [LoginController::class, 'whatAmI'])->name('app.wtfAmI');
            Route::get('profile', [ProfileController::class, 'show'])->name('app.profile');
            Route::get('purchase-history', [ShoppingCartController::class, 'purchaseHistory'])->name('app.purchase-history');
        });
    });

    Route::prefix('desktop')->group(function () {
    });
});