<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return redirect()->route('checkout');
});
Route::get('/checkout', [PaymentController::class, 'showCheckoutForm'])->name('checkout');
