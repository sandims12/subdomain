<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminSkpdController;
use App\Http\Controllers\AdminPermohonanController;
use App\Http\Controllers\AdminSubdomainController;
use App\Http\Controllers\SkpdPermohonanController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SkpdDashboardController;
use App\Http\Controllers\SkpdSubdomainController;

// ===========================
// 🔹 A. ROUTE UTAMA / LOGIN
// ===========================

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect('/login');
});

// Halaman login & register
Route::get('/login', [AdminAuthController::class, 'index'])->name('login');
Route::post('/login', [AdminAuthController::class, 'doLogin']);
Route::get('/register', [AdminAuthController::class, 'nampilnoregister'])->name('register');
Route::post('/register', [AdminAuthController::class, 'register']);
Route::post('/user/update-name', [AdminAuthController::class, 'updateName'])->name('user.updateName');

// Logout
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');


// ===========================
// 🔹 B. ROLE ADMIN
// ===========================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // ✅ CRUD Data SKPD (Admin bisa tambah, edit, hapus SKPD)
    Route::get('admin/skpd', [AdminSkpdController::class, 'index'])->name('admin.skpd.index');

    // Route untuk menambah SKPD
    Route::get('admin/skpd/create', [AdminSkpdController::class, 'create'])->name('admin.skpd.create');
    Route::post('admin/skpd', [AdminSkpdController::class, 'store'])->name('admin.skpd.store');

    // Route untuk mengedit dan menghapus SKPD
    Route::get('admin/skpd/{id}/edit', [AdminSkpdController::class, 'edit'])->name('admin.skpd.edit');
    Route::put('admin/skpd/{id}', [AdminSkpdController::class, 'update'])->name('admin.skpd.update');
    Route::delete('admin/skpd/{id}', [AdminSkpdController::class, 'destroy'])->name('admin.skpd.destroy');

    // ✅ Permohonan Subdomain
    Route::get('/admin/permohonan', [AdminPermohonanController::class, 'index'])
        ->name('admin.permohonan.index');
    Route::get('/admin/permohonan/{id}', [AdminPermohonanController::class, 'show'])
        ->name('admin.permohonan.show');
    Route::post('/admin/permohonan/{id}/update', [AdminPermohonanController::class, 'updateStatus'])
        ->name('admin.permohonan.updateStatus');

    // ✅ CRUD Data Subdomain (dengan nama route rapih)
    Route::resource('admin/subdomain', AdminSubdomainController::class)->names([
        'index'   => 'admin.subdomain.index',
        'create'  => 'admin.subdomain.create',
        'store'   => 'admin.subdomain.store',
        'show'    => 'admin.subdomain.show',
        'edit'    => 'admin.subdomain.edit',
        'update'  => 'admin.subdomain.update',
        'destroy' => 'admin.subdomain.destroy',
    ]);
});


// ===========================
// 🔹 C. ROLE SKPD
// ===========================
Route::middleware(['auth', 'role:skpd'])->group(function () {

    // Dashboard SKPD
    Route::get('/skpd/dashboard', [SkpdDashboardController::class, 'index'])
        ->name('skpd.dashboard');

    // Pengajuan Permohonan Subdomain
    Route::get('/skpd/permohonan/create', [SkpdPermohonanController::class, 'create'])
        ->name('skpd.permohonan.create');

    Route::post('/skpd/permohonan', [SkpdPermohonanController::class, 'store'])
        ->name('skpd.permohonan.store');

         //  Daftar Subdomain milik SKPD yang login
    Route::get('/skpd/subdomain', [SkpdSubdomainController::class, 'index'])
    ->name('skpd.subdomain.index');

    Route::get('/skpd/permohonan-saya', [SkpdPermohonanController::class, 'index'])
    ->name('skpd.permohonan.index');
    
    // ✅ Menu "Permohonan Saya" – route utama
    Route::get('/skpd/permohonansaya', [SkpdPermohonanController::class, 'index'])
        ->name('skpd.permohonansaya.index');

   
});
