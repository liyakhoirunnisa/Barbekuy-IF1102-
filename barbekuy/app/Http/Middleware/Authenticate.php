<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle unauthenticated users.
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return route('login.form');
        }

        return null;
    }
}
