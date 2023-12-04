<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountSwitchController;

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


Route::post('/switch-account', [AccountSwitchController::class, 'switchAccount'])->name('switch.account');


Route::get('/', function () {
    return view('welcome');
});

// Routes with verification
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route to the dashboard (main page)
    Route::get('/dashboard', function () {

        // Getting the authenticated user and checking its type
        $user = Auth::user(); 
        if ($user && $user->type === "Buyer") {

            // returning buyer-dashboard if it is not null and is Buyer
            return view('buyer-dashboard');
        }

        // otherwise returning the seller dashboard
        return view('seller-dashboard');
        
    })->name('dashboard');
});

