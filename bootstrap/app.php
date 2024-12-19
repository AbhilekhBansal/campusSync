<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => RoleMiddleware::class
        ]);
        $middleware->redirectTo(
            guests: 'login',
            users: fn() => match (Auth::user()->role) {
                'superadmin' => route('admin.dashboard'),
                'admin' => route('admin.dashboard'),
                'teacher' => route('teacher.dashboard'),
                'student' => route('student.dashboard'),
                default => route('dashboard'), // Fallback
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
