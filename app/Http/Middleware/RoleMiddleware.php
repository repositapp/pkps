<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  \Closure  $next
     * @param  mixed  ...$roles  Role yang diizinkan (admin, author, dll)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Cek apakah role user ada di daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request); // lanjutkan request ke route/controller
        }

        // Jika role tidak cocok, tolak akses
        abort(403, 'Unauthorized: You do not have access to this resource.');
    }
}
