<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    private function guardAdmin(): void
    {
        if ((auth()->user()->role ?? 'pegawai') !== 'admin') abort(403);
    }

    public function index(Request $request)
    {
        $this->guardAdmin();

        $q = User::query()->with('karyawan')->orderBy('id_pegawai');

        if ($request->filled('q')) {
            $term = trim((string) $request->q);
            $q->where(function ($w) use ($term) {
                $w->where('id_pegawai', 'like', "%{$term}%")
                  ->orWhere('name', 'like', "%{$term}%");
            });
        }

        if ($request->filled('role')) {
            $q->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') $q->where('is_active', true);
            if ($request->status === 'inactive') $q->where('is_active', false);
        }

        if ($request->filled('must_change')) {
            if ($request->must_change === 'yes') $q->where('must_change_password', true);
            if ($request->must_change === 'no') $q->where('must_change_password', false);
        }

        $users = $q->paginate((int) $request->get('per_page', 25))->withQueryString();

        return view('admin.manageUser', compact('users'));
    }

    public function toggleActive(User $user)
    {
        $this->guardAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Status pengguna diperbarui.');
    }

    public function resetPassword(User $user)
    {
        $this->guardAdmin();

        $defaultPassword = (string) env('DEFAULT_PASSWORD_KANTOR_INDUK', 'Jollong@12345');

        $user->password = $defaultPassword;
        $user->must_change_password = true;
        $user->password_changed_at = null;
        $user->save();

        return back()->with('success', 'Password berhasil di-reset ke default & user wajib ganti password saat login.');
    }
}
