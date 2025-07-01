<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\APIKeyController;
use App\Http\Controllers\PlansController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// PAGE MAIN
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// CONTROLLER WEB PAGE AUTHEN
Route::middleware(['auth', 'verified'])->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->name('dashboard');
    Route::get('/dashboard/live-stats', [DashboardController::class, 'liveStats'])->name('dashboard.live.stats');
    Route::post('/dashboard', [DashboardController::class, 'resetData'])->name('reset.analysis');
    // SECURITY ANALYST
    Route::get('/securityanalyst', [SecurityController::class, 'SecurityControl'])->name('security.incidents');
    Route::put('/security/{log}', [SecurityController::class, 'updateSecurityLog'])->name('security.update');
    Route::get('/incidents', [SecurityController::class, 'ResolvedSecurity'])->name('resolved.incidents');
    // ANALYST LOGS
    Route::get('/loginanalyst', [SecurityController::class, 'LogsAnalyst'])->name('logs.analyst');
    // CHANGE PUBLIC KEY
    Route::get('/publickey', [APIKeyController::class, 'APIKey'])->name('publickey');
    Route::post('/publickey', [ApiKeyController::class, 'Regenerate'])->name('regenerate.key');
    Route::get('/plans', [PlansController::class, 'Plans'])->name('plans');
});

// PROFIL WEPAGE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'ProfilDetail'])->name('profile.layouts');
    // AVATAR UPLOAD
    Route::post('/update', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    // UPDATE EMAILS
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // DELET USERS
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
