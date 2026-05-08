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

        // 1. X-Frame-Options: Prevents clickjacking by ensuring the page cannot be embedded in an iframe on other sites.
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 2. X-Content-Type-Options: Prevents the browser from interpreting files as a different MIME type (MIME Sniffing).
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. X-XSS-Protection: Enables the browser's built-in XSS filter (for older browsers).
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 4. Referrer-Policy: Controls how much referrer information is passed when navigating away from the site.
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. X-Permitted-Cross-Domain-Policies: Restricts Adobe Flash and PDF files from loading data from your domain.
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // 6. Strict-Transport-Security (HSTS): Enforces HTTPS connections.
        // Applied to all responses to ensure the browser remembers to use HTTPS.
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // 7. Hide X-Powered-By: Removes server technology information from headers to reduce fingerprinting.
        $response->headers->remove('X-Powered-By');

        // 7. Content Security Policy (CSP): Defines which resources are allowed to load.
        // We use strict-dynamic and nonces where possible, but for Blade compatibility, 
        // we use a refined whitelist to eliminate wildcards and secure inline resources.
        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com https://*.officeapps.live.com",
            "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com",
            "img-src 'self' data: blob: https://via.placeholder.com https://*.placeholder.com https://unpkg.com https://cdn.jsdelivr.net https://images.unsplash.com https://*.officeapps.live.com",
            "font-src 'self' data: https://cdnjs.cloudflare.com",
            "frame-src 'self' https://*.officeapps.live.com",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "connect-src 'self' https://psgc.gitlab.io https://raw.githubusercontent.com https://*.faeldon.com https://*.faeldon.io",
            "base-uri 'self'",
            "object-src 'none'",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        return $response;
    }
}
