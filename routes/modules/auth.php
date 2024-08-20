<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SigninUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::middleware('guest')->group(function () {
    Route::get('/signin', [SigninUserController::class, 'signinView'])->name('signin');
    Route::post('/signin/authenticate', [SigninUserController::class, 'signin'])->name('signin_handler');

    Route::get('/auth/google', [SigninUserController::class, 'redirectToGoogle'])->name('google_auth');
    Route::get('/auth/google/callback', [SigninUserController::class, 'handleGoogleCallback']);

    Route::get('/register', [RegisteredUserController::class, 'registerView'])->name('register');
    Route::post('/register/authenticate', [RegisteredUserController::class, 'register'])->name('register_handler');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::get('/logout', [SigninUserController::class, 'logout'])->name('logout');
});