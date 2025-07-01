<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class APIKeyController extends Controller
{
    public function APIKey(Request $request): View
    {
        return view('apikey');
    }

    public function Regenerate(): RedirectResponse
    {
        $user = Auth::user();
        $user->generateApiKey();

        return back()->with('success', 'api-updated');
    }
}
