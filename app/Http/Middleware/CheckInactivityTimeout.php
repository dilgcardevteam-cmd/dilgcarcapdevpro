<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckInactivityTimeout
{
    public const INACTIVITY_WARNING_SECONDS = 1800;
    public const LOGOUT_COUNTDOWN_SECONDS = 60;
    private const TIMEOUT_SECONDS = self::INACTIVITY_WARNING_SECONDS + self::LOGOUT_COUNTDOWN_SECONDS;

    /**
     * Enforce inactivity timeout on every request.
     * The browser warning appears after 30 minutes, then logout follows after a 60-second countdown.
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
