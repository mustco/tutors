<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Jika tidak, arahkan kembali ke dashboard atau halaman lain
        // Atau Anda bisa abort(403) untuk Forbidden
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        // Atau: abort(403, 'Unauthorized action.');
    
    }
}
