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

        if ($user && !$user->profile_completed) {
            // Allow specific accounts to proceed without forcing profile setup
            if (isset($user->email) && strtolower($user->email) === 'co_participant@gmail.com') {
                return $next($request);
            }
            if ($request->routeIs('profile.setup') || $request->routeIs('profile.setup.store') || $request->routeIs('logout')) {
                return $next($request);
            }
            return redirect()->route('profile.setup')->with('profile_required', true);
        }

        return $next($request);
    }
}
