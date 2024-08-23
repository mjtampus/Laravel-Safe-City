<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictedMidddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in
        if (auth()->check()) {
            // Check if the user has the 'admin' role
            if (auth()->user()->role === 'restricted') {
                return $next($request);
            }
        }

        // Redirect or return an error response if not authorized
        return redirect('/logout')->with('error', 'Unauthorized access.');
    }
}
