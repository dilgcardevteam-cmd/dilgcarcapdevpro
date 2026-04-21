<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckInactivityTimeout
{
    /**
     * Enforce role-based inactivity timeout on every request.
     * Admin-like roles: 5 minutes. Others: 10 minutes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $session = $request->session();
        $now = now()->getTimestamp();
        $lastActivity = (int) $session->get('last_activity_at', $now);
        $timeoutSeconds = static::resolveTimeoutSeconds((string) (Auth::user()->role ?? ''));

        if (($now - $lastActivity) >= $timeoutSeconds) {
            Auth::logout();
            $session->invalidate();
            $session->regenerateToken();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Your session expired due to inactivity.',
                    'redirect' => route('login'),
                ], 440);
            }

            return redirect()
                ->route('login')
                ->with('security_message', 'Your session expired due to inactivity. Please log in again.');
        }

        $session->put('last_activity_at', $now);

        return $next($request);
    }

    public static function resolveTimeoutSeconds(string $role): int
    {
        $role = strtolower(trim($role));
        $isAdmin = $role === 'admin'
            || $role === 'super_admin'
            || Str::contains($role, 'admin');

        return $isAdmin ? 300 : 600;
    }
    
}
