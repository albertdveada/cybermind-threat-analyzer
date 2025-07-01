<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\SecurityController;

Route::middleware(['public.key', 'client.status'])->group(function (){
    Route::post('/analyze-logins', [SecurityController::class, 'AnalyzeLogin']);
    Route::post('/log-analysis', [SecurityController::class, 'AnalyzeSecurity']);
});