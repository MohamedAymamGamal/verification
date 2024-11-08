<?php

use App\Http\Controllers\MerchantAuth\AuthenticatedSessionController;
use App\Http\Controllers\MerchantAuth\ConfirmablePasswordController;
use App\Http\Controllers\MerchantAuth\EmailVerificationNotificationController;
use App\Http\Controllers\MerchantAuth\EmailVerificationPromptController;
use App\Http\Controllers\MerchantAuth\NewPasswordController;
use App\Http\Controllers\MerchantAuth\PasswordController;
use App\Http\Controllers\MerchantAuth\PasswordResetLinkController;
use App\Http\Controllers\MerchantAuth\RegisteredUserController;
use App\Http\Controllers\MerchantAuth\VerifyEmailController;
use Illuminate\Auth\Middleware\MerchantEnsureEmailIsVerified;
use Illuminate\Support\Facades\Route;

 Route::middleware('guest:merchant')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //     ->name('password.request');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //     ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //     ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //     ->name('password.store');
});

 Route::middleware('merchant')->group(function () {
        Route::get('verify-email', [EmailVerificationPromptController::class])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{token}', [MerchantEnsureEmailIsVerified::class, 'verify'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController ::class, 'resend'])
        ->name('verification.send');


    //     Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    //         ->name('password.confirm');

    //     Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

