<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    /**
     * Handle an incoming request and apply security headers.
     * Fixes vulnerabilities related to OWASP ZAP scan (Medium/Low).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // If the response is not a standard HTML response, just return it
        if (!$response instanceof \Illuminate\Http\Response && !$response instanceof \Symfony\Component\HttpFoundation\Response) {
            return $response;
        }

        // 1. X-Frame-Options: Prevents clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 2. X-Content-Type-Options: Prevents MIME Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. X-XSS-Protection: Enables the browser's built-in XSS filter
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 4. Referrer-Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. X-Permitted-Cross-Domain-Policies
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // 6. Strict-Transport-Security (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // 7. Hide X-Powered-By
        $response->headers->remove('X-Powered-By');

        // 8. Permissions-Policy
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=(), fullscreen=(self), autoplay=(), encrypted-media=()');

        // 9. Content Security Policy (CSP): Balanced for functionality
        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com https://fonts.googleapis.com",
            "img-src 'self' data: blob: https://via.placeholder.com https://unpkg.com https://cdn.jsdelivr.net https://images.unsplash.com https://*.faeldon.com",
            "font-src 'self' data: https://cdnjs.cloudflare.com https://fonts.gstatic.com",
            "frame-src 'self' https://view.officeapps.live.com https://*.officeapps.live.com",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "connect-src 'self' https://psgc.gitlab.io https://raw.githubusercontent.com https://*.faeldon.com https://*.faeldon.io",
            "base-uri 'self'",
            "object-src 'none'",
            "manifest-src 'self'",
            "worker-src 'self'",
            "media-src 'self'",
            "upgrade-insecure-requests",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        return $response;
    }
}
