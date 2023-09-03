<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TokenAuthorization
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        $request->request->add([
            'tokenAuthorizationAccount' => null,
        ]);

        $authorization = $request->header('Authorization');
        if (!$authorization) {
            return $next($request);
        }

        /*
        $token = '';
        $request->request->add([
            'tokenAuthorizationAccount' => getAccountByToken($token),
        ]);
        */

        return $next($request);
    }
}

/*
example:

    [AccountServiceProvider]
       $this->app['router']->pushMiddlewareToGroup('auth.token', TokenAuthorization::class);

    [Routes/api.php]
       [
           'middleware' => ['auth.token'],
       ]

    [controller]
       $account = $request->get('tokenAuthorizationAccount');

   [curl]
        curl 'http://127.0.0.1:8080/api/hello' -H "Authorization: Bearer 123456"

*/
