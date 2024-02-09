<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\ShoppingListController;
use App\Http\Controllers\Api\V1\SellerController;
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

Route::post('login', ['uses' => 'App\Http\Controllers\Api\V1\LoginController@login'])->prefix('mobile')->name('mobile.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::post('login', [LoginController::class, 'login']);
    });

    Route::prefix('mobile')->group(function () {
        Route::post('validate', [LoginController::class, 'validateToken'])->name('mobile.validate-token');
        Route::get('products', [ProductController::class, 'listAllAvailableProducts'])->name('mobile.products');
        Route::post('add-to-cart', [ShoppingListController::class, 'addToShoppingList'])->name('mobile.add-to-cart');
        Route::get('cart', [ShoppingListController::class, 'cart'])->name('mobile.cart');
        Route::get('dash', [SellerController::class, 'dash'])->name('mobile.seller-dash');
        Route::get('seller-edit/{product_id}', [SellerController::class, 'edit'])->name('mobile.seller-edit');
        Route::post('edit-product', [SellerController::class, 'updateProduct'])->name('mobile.edit-product');
        Route::get('wtfAmI', [LoginController::class, 'whatAmI'])->name('mobile.wtfAmI');
        Route::post('change-type', [LoginController::class, 'changeMyType'])->name('mobile.change-type');
        Route::post('product-delete/{product_id}', [SellerController::class, 'destroy'])->name('mobile.product-delete');
    });

    Route::prefix('desktop')->group(function () {
    });
});
