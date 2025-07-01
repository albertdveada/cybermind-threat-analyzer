<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PublicKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->query('public_key');

        if (!$key) {
            return response()->json(['message' => 'Public KEY is required.'], 401);
        }

        $user = User::where('public_key', $key)
                     ->where('key_expires_at', '>', now())
                     ->first();

        if (!$user) {
            return response()->json(['message' => 'Public KEY expired! Please renew your subscription.'], 403);
        }

        Auth::setUser($user);

        return $next($request);
    }
}
