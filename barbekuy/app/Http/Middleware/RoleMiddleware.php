<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($role === 'admin' && $user->role !== 'admin') {
            return redirect()->route('beranda');
        }

        if ($role === 'user' && $user->role !== 'user') {
            return redirect()->route('admin.beranda');
        }

        return $next($request);
    }
}
