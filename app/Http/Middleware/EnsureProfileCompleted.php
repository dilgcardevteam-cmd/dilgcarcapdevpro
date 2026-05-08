<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileCompleted
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user && $user->status === 'pending') {
            if ($request->routeIs('pending.approval') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('pending.approval');
        }

        return $next($request);
    }
}
