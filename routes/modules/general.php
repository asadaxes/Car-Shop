<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;

Route::get('/', [GeneralController::class, 'home'])->name('home');
Route::get('/vehicle/{car}', [GeneralController::class, 'vehicle_details'])->name('vehicle_details');
Route::get('/model', [GeneralController::class, 'vehicle_model_search'])->name('vehicle_model_search');
Route::get('/search', [GeneralController::class, 'search_query'])->name('search_query');
Route::get('/blogs', [GeneralController::class, 'blogs'])->name('blogs');
Route::get('/blogs/{article}', [GeneralController::class, 'blogs_details'])->name('blogs_details');
Route::get('/p/{slug}', [GeneralController::class, 'page_details'])->name('page_details');

Route::middleware('auth', 'active', 'verified')->group(function () {
    Route::get('/vehicles/publish-new', [GeneralController::class, 'vehicle_publish_new'])->name('vehicle_publish_new');
    Route::post('/vehicles/publish-new/handler', [GeneralController::class, 'vehicle_publish_new_handler'])->name('vehicle_publish_new_handler');
    Route::post('/secure-pay/success', [GeneralController::class, 'success'])->name('payment_success');
    Route::post('/secure-pay/fail', [GeneralController::class, 'fail'])->name('payment_fail');
    Route::post('/secure-pay/cancel', [GeneralController::class, 'cancel'])->name('payment_cancel');
    Route::post('/secure-pay/ipn', [GeneralController::class, 'ipn'])->name('payment_ipn');
});