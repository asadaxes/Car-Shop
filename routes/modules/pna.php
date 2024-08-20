<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PnaController;

Route::get('/parts-and-accessories', [PnaController::class, 'landing_page'])->name('pna_landing_page');
Route::get('/parts-and-accessories/{slug}', [PnaController::class, 'product_view'])->name('pna_product_view');
Route::get('/my-cart', [PnaController::class, 'cart'])->name('pna_cart');

Route::middleware('auth', 'active', 'verified')->group(function () {
    Route::post('/parts-and-accessories/product/review/handler', [PnaController::class, 'product_review_handler'])->name('pna_product_review_handler');
    Route::get('/my-cart/checkout', [PnaController::class, 'checkout'])->name('pna_checkout');
    Route::post('/my-cart/checkout/handler', [PnaController::class, 'checkout_handler'])->name('pna_checkout_handler');
    Route::get('/my-cart/clear-payment-success-session', [PnaController::class, 'clear_payment_success_session'])->name('clear_payment_success_session');
});