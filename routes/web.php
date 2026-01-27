<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ChangePasswordController;

use App\Http\Controllers\Worker\DashboardWorkerController;
use App\Http\Controllers\Worker\InputProduksiKopiController;
use App\Http\Controllers\Worker\InputLabaRugiController;
use App\Http\Controllers\Worker\ExportProduksiKopiController;
use App\Http\Controllers\Worker\ExportLabaRugiController;

use App\Http\Controllers\Admin\InputKaryawanBaruController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\HTTP\Controllers\Admin\AdminUserController;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\KategoriKeuangan;
use App\Models\ActivityLog;


// ================= PUBLIK =================
Route::get('/', function () {
    return view('dashboardPublic');
})->name('dashboardPublic');


// ================= AUTH =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LogoutController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ================= FORCE CHANGE PASSWORD =================
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'form'])
        ->name('password.change.form');

    Route::post('/change-password', [ChangePasswordController::class, 'save'])
        ->name('password.change.save');
});


// ================= INTERNAL (AUTH) =================
Route::middleware('auth')->group(function () {

    // WORKER DASHBOARD
    Route::middleware('force.password')->group(function () {

        Route::get('/dashboard', [DashboardWorkerController::class, 'index'])
            ->name('dashboard');

        Route::get('/profil', function () {
            return view('worker.profilWorker');
        })->name('worker.profil');

        Route::get('/produksi-kopi', [InputProduksiKopiController::class, 'index'])
            ->name('worker.produksi_kopi.index');

        Route::post('/produksi-kopi', [InputProduksiKopiController::class, 'store'])
            ->name('worker.produksi_kopi.store');

        Route::put('/produksi-kopi/{produksiKopi}', [InputProduksiKopiController::class, 'update'])
            ->name('worker.produksi_kopi.update');

        Route::delete('/produksi-kopi/{produksiKopi}', [InputProduksiKopiController::class, 'destroy'])
            ->name('worker.produksi_kopi.destroy');

        Route::get('/laba-rugi', [InputLabaRugiController::class, 'index'])
            ->name('worker.laba_rugi.index');

        Route::post('/laba-rugi', [InputLabaRugiController::class, 'store'])
            ->name('worker.laba_rugi.store');

        Route::put('/laba-rugi/{tahun}/{bulan}', [InputLabaRugiController::class, 'update'])
            ->name('worker.laba_rugi.update');

        Route::delete('/laba-rugi/{tahun}/{bulan}', [InputLabaRugiController::class, 'destroy'])
            ->name('worker.laba_rugi.destroy');

        Route::get('/export/laba-rugi', [ExportLabaRugiController::class, 'labaRugi'])
            ->name('worker.export.laba_rugi');

        Route::get('/export/produksi-kopi', [ExportProduksiKopiController::class, 'produksiKopi'])
            ->name('worker.export.produksi_kopi');
    });


    // ================= ADMIN =================
    Route::prefix('admin')
        ->middleware('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', function () {

                $today = Carbon::today();

                $adminStats = [
                    'total_users' => (int) User::count(),
                    'total_karyawan' => (int) Karyawan::count(),
                    'kategori_keuangan' => class_exists(KategoriKeuangan::class)
                        ? (int) KategoriKeuangan::count()
                        : 0,
                    'logs_today' => (int) ActivityLog::whereDate('created_at', $today)->count(),
                ];

                $recentLogs = ActivityLog::query()
                    ->with(['user', 'karyawan'])
                    ->latest()
                    ->limit(10)
                    ->get();

                return view('admin.dashboardAdmin', compact('adminStats', 'recentLogs'));
            })->name('dashboard');

            Route::get('/karyawan', function () {

                $karyawanList = Karyawan::query()
                    ->orderByDesc('created_at')
                    ->orderByDesc('personnel_number')
                    ->get();

                return view('admin.InputDataKaryawan', compact('karyawanList'));
            })->name('karyawan.create');

            Route::post('/karyawan', [InputKaryawanBaruController::class, 'store'])
                ->name('karyawan.store');

            Route::put('/karyawan/{personnel_number}', [InputKaryawanBaruController::class, 'update'])
                ->name('karyawan.update');

            Route::delete('/karyawan/{personnel_number}', [InputKaryawanBaruController::class, 'destroy'])
                ->name('karyawan.destroy');

            Route::get('/activity-logs', [ActivityLogController::class, 'index'])
                ->name('activity_logs.index');

            Route::get('/activity-logs/latest', [ActivityLogController::class, 'latest'])
                ->name('activity_logs.latest');

            Route::get('/activity-logs/{id}', [ActivityLogController::class, 'show'])
                ->name('activity_logs.show');

            Route::get('/users', [AdminUserController::class, 'index'])
                ->name('users.index');

            Route::post('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])
                ->name('users.toggleActive');

            Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])
                ->name('users.resetPassword');
            
        });
});
