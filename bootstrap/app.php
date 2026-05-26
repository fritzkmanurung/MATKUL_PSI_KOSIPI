<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom error rendering untuk halaman error yang lebih baik UX
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->is('admin/*') || $request->is('member/*')) {
                // Untuk Filament panels, biarkan Filament handle sendiri
                return null;
            }
            return response()->view('errors.404', ['exception' => $e], 404);
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->is('admin/*') || $request->is('member/*')) {
                return null;
            }
            return response()->view('errors.403', ['exception' => $e], 403);
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            $status = $e->getStatusCode();
            
            if ($request->is('admin/*') || $request->is('member/*')) {
                return null;
            }

            if (in_array($status, [419, 503])) {
                return response()->view("errors.{$status}", ['exception' => $e], $status);
            }

            return null; // Biarkan Laravel handle default
        });
    })->create();
