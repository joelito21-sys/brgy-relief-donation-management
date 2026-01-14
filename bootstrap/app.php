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
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'donor' => \App\Http\Middleware\DonorMiddleware::class,
            'resident.approved' => \App\Http\Middleware\ResidentApproved::class,
            'donor.verified' => \App\Http\Middleware\EnsureDonorEmailIsVerified::class,
        ]);
        
        // Override default guest redirect to use donor login instead of generic login
        $middleware->redirectGuestsTo(function () {
            // If accessing admin routes, redirect to admin login
            if (request()->is('admin*')) {
                return route('admin.login.form');
            }
            // Otherwise, redirect to donor login
            return route('donor.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
