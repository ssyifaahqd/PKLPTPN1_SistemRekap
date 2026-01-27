<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) return $next($request);

        if (($user->is_active ?? true) === false) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['id_pegawai' => 'Akun kamu nonaktif. Hubungi admin.']);
        }

        if (($user->role ?? 'pegawai') === 'admin') {
            return $next($request);
        }

        $allowed = $request->routeIs(
            'password.change.form',
            'password.change.save',
            'logout'
        );

    
        if (($user->must_change_password ?? false) && !$allowed) {
            return redirect()->route('password.change.form');
        }

        return $next($request);
    }
}
