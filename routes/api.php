<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
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
        Route::post('login', ['uses' => 'App\Http\Controllers\Api\V1\LoginController@login']);
    });

    Route::prefix('mobile')->group(function () {
        Route::post('validate', ['uses' => 'App\Http\Controllers\Api\V1\LoginController@validateToken'])->name('mobile.validate-token');
        Route::get('products', ['uses' => 'App\Http\Controllers\Api\V1\ProductController@listAllAvailableProducts'])->name('mobile.products');
        Route::post('add-to-cart', ['uses' => 'App\Http\Controllers\Api\V1\ShoppingListController@addToShoppingList'])->name('mobile.add-to-cart');
        Route::get('cart', ['uses' => 'App\Http\Controllers\Api\V1\ShoppingCartController@cart'])->name('mobile.cart');
        Route::get('dash', ['uses' => 'App\Http\Controllers\Api\V1\SellerController@dash'])->name('mobile.seller-dash');
        Route::get('seller-edit/{product_id}', ['uses' => 'App\Http\Controllers\Api\V1\SellerController@edit'])->name('mobile.seller-edit');
        Route::post('edit-product', ['uses' => 'App\Http\Controllers\Api\V1\SellerController@updateProduct'])->name('mobile.edit-product');
        Route::get('wtfAmI', ['uses' => 'App\Http\Controllers\Api\V1\LoginController@whatAmI'])->name('mobile.wtfAmI');
        Route::post('change-type', ['uses' => 'App\Http\Controllers\Api\V1\LoginController@changeMyType'])->name('mobile.change-type');
        Route::post('product-delete/{product_id}', ['uses' => 'App\Http\Controllers\Api\V1\SellerController@destroy'])->name('mobile.product-delete');
    });

    Route::prefix('desktop')->group(function () {
    });
});
