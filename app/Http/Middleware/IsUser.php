<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has admin role
        if (Auth::check() && Auth::user()->role === 0) {
            return $next($request);
        }

        // Optionally, you can redirect to a specific page or return a 403 error
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}
