<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
        	'abilities' => CheckAbilities::class,
        	'ability' => CheckForAnyAbility::class,
        	'productManager' => \App\Http\Middleware\EnsureUserIsProductManager::class,
    	]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 👇 針對 Sanctum 認證失敗
    
    $exceptions->render(function (AuthenticationException $e, $request) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'requested_at' => now()->toDateTimeString(),
        ], 401); //$this->getStatusCode($e) 401換成這個會redirect to a 網頁
    });
	
    $exceptions->render(function (AccessDeniedHttpException $e, $request) {
    	return response()->json([
        	'status' => 'error',
        	'message' => $e->getMessage(),
        	'requested_at' => now()->toDateTimeString(),
    	], 403);
	});

    })->create();
