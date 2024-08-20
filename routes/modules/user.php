<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth', 'active')->group(function () {
    Route::get('/my-profile', [UserController::class, 'profile'])->name('user_profile');
    Route::post('/my-profile/update-handler', [UserController::class, 'profile_update'])->name('user_profile_update');
    Route::put('/my-profile/security/password-update', [UserController::class, 'profile_password_update'])->name('user_profile_password_update');
    Route::delete('/my-profile/security/profile-deletion', [UserController::class, 'profile_delete'])->name('user_profile_delete');
    Route::post('/my-profile/updateuserimg', [UserController::class, 'update_profile_img'])->name('user_update_profile_img');
});

Route::middleware('auth', 'active', 'verified')->group(function () {
    Route::get('/my-vehicles', [UserController::class, 'my_vehicles'])->name('user_my_vehicles');
    Route::get('/my-orders', [UserController::class, 'my_orders'])->name('user_my_orders');
});