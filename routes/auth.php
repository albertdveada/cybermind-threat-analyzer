<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // REGISTATION
    Route::get('registration', [RegisteredUserController::class, 'Registration'])->name('registration');
    Route::post('registration', [RegisteredUserController::class, 'Created']);
    // SIGIN
    Route::get('signin', [AuthenticatedSessionController::class, 'Signin'])->name('signin');
    Route::post('signin', [AuthenticatedSessionController::class, 'Continue']);
    // RESET PASSWORD SEND LINKConfirmablePasswordController
    Route::get('forgot-password', [PasswordResetLinkController::class, 'ResetPassword'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'PasswordUpdate'])->name('password.email');
    // NEW LINK YANG DITERIMA OLEH EMAIL
    Route::get('reset-password/{token}', [NewPasswordController::class, 'UpdatePassword'])->name('password.reset');
    // NEW PASSWORD
    Route::post('reset-password', [NewPasswordController::class, 'NewPassword'])->name('password.change');
});

Route::middleware('auth')->group(function () {
    // VERIFY EMAIL
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    // CONFRIM PASSWORD
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    // CHANGE PASSWORD
    Route::put('password', [PasswordController::class, 'ChangePassword'])->name('password.update');
    // LOGOUT
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
