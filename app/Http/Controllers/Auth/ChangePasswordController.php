<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function form(Request $request)
    {
        $user = $request->user();

        if (($user->role ?? 'pegawai') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.changePassword');
    }

    public function save(Request $request)
    {
        $user = $request->user();

        if (($user->role ?? 'pegawai') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini salah.'])
                ->withInput();
        }

       
        $user->password = $request->password; 
        $user->must_change_password = false;
        $user->password_changed_at = now();
        $user->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
