<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check if user status is active
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun Anda belum aktif. Silakan hubungi administrator.');
            }
            
            if ($user->role === 'admin') {
                return $next($request);
            }
        }

        return redirect()->route('welcome');
    }
}
