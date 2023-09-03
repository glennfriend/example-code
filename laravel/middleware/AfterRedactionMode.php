<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Core\Enums\RedactionModeEnum;
use Modules\Core\Supports\RedactionConvert;


class RedactionMode
{
    public function __construct()
    {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        $redactionMode = is_string($request->header('X-Redaction-Mode'))
            ? $request->header('X-Redaction-Mode')
            : null;

        if (!$redactionMode) {
            $redactionMode = is_string($request->header('X-redaction-mode'))
                ? $request->header('X-redaction-mode')
                : null;
        }

        $redactionMode = $redactionMode ?? RedactionModeEnum::REDACTED->value;


        if ($redactionMode === RedactionModeEnum::ORIGINAL->value) {
            return $next($request);
        }

        /**
         * @var JsonResponse $response
         */
        $response = $next($request);


        // convert to redacted data
        // ...


        Log::debug(get_class($response));
        // any, entity, collection, json resource ...
        $mixed = get_class($response->getOriginalContent());
        // is model         -> RedactionConvert::class;
        // is collection    -> RedactionConvert::class;


        return $response;
    }
}


/*

// route/api.php
Route::group([
    'prefix' => 'contacts',
    'middleware' => ['data:redaction'],
], function () {
    Route::get('/{contact}', 'ContactController@show');
});

// Modules/Core/Providers/CoreServiceProvider.php
class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerMiddlewares();
    }

    protected function registerMiddlewares(): void
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('data:redaction', \Modules\Core\Http\Middleware\RedactionMode::class);
    }
}








*/