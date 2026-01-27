<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Auth.loginForm');
    }

    public function login(Request $request)
    {
        $request->validate([
            'id_pegawai' => ['required', 'string'],
            'password'   => ['required', 'string'],
        ]);

        $credentials = [
            'id_pegawai' => (string) $request->id_pegawai,
            'password'   => (string) $request->password,
        ];

        if (schema_has_column('users', 'is_active')) {
            $credentials['is_active'] = 1;
        }

        $remember = (bool) $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['login' => 'ID pegawai atau password salah.'])
                ->withInput();
        }

        $request->session()->regenerate();

        $user = $request->user();

        if (($user->role ?? 'pegawai') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}


function schema_has_column(string $table, string $column): bool
{
    try {
        return \Illuminate\Support\Facades\Schema::hasColumn($table, $column);
    } catch (\Throwable $e) {
        return false;
    }
}
