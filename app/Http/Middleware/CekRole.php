<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Periksa apakah peran pengguna termasuk dalam roles yang diizinkan
        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika peran pengguna adalah "kasir", redirect ke dashboardkasir
        if ($user && $user->role === 'kasir') {
            return redirect('/kasir/dashboarduser');
        }

        abort(403, 'Unauthorized access.');
    }
}

