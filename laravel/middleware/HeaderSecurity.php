<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * 請查閱 https://laravel-news.com/laravel-security-middleware
 */
final class HeaderSecurity
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        /**
         * @var Response $response
         */
        $response = $next($request);
 
        $response->headers->set(
            key: 'Strict-Transport-Security',
            values: config('headers.strict-transport-security'),
        );
 
        return $response;
    }
}
