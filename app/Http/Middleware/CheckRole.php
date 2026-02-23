<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil id_role user yang sedang login
        $userRole = Auth::user()->role_name;

        // Periksa apakah role user ada di dalam array roles yang diizinkan
        if (in_array($userRole, ['Admin'])) {
            return $next($request); // Lanjutkan jika cocok
        }
    
        // Jika role tidak cocok, kembalikan error
        abort(404, 'Not Found');
    }
}
