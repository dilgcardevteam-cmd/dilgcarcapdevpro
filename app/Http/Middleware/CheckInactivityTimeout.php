<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckInactivityTimeout
{
    private const TIMEOUT_SECONDS = 3600;

    /**
     * Enforce role-based inactivity timeout on every request.
     * Users are logged out after 1 hour of inactivity.
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
        return self::TIMEOUT_SECONDS;
    }
    
}
