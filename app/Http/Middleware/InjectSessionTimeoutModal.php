<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class InjectSessionTimeoutModal
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldInject($request, $response)) {
            return $response;
        }

        $content = (string) $response->getContent();
        $needle = '</body>';

        if (stripos($content, $needle) === false) {
            return $response;
        }

        $injected = str_contains($content, 'id="capdev-app-dialog-root"')
            ? ''
            : View::make('components.app-dialogs')->render();

        if (Auth::check() && ! str_contains($content, 'id="cdp-session-timeout-root"')) {
            $injected .= PHP_EOL . View::make('components.session-timeout')->render();
        }

        if (trim($injected) === '') {
            return $response;
        }

        $content = preg_replace('/<\/body>/i', $injected . PHP_EOL . '</body>', $content, 1);

        if (is_string($content)) {
            $response->setContent($content);
            $response->headers->remove('Content-Length');
        }

        return $response;
    }

    private function shouldInject(Request $request, Response $response): bool
    {
        if (! $response->isSuccessful() || $request->expectsJson() || $request->ajax()) {
            return false;
        }

        if ($request->routeIs('login', 'register', 'password.*', 'auth.google.*', 'logout', 'session.keep-alive')) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type', '');

        return $contentType === '' || str_contains(strtolower($contentType), 'text/html');
    }
}
