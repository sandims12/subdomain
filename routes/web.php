<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminSkpdController;
use App\Http\Controllers\AdminPermohonanController;
use App\Http\Controllers\AdminSubdomainController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
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

    // 🔴 DELETE PERMOHONAN — HANYA UNTUK STATUS DITOLAK
    Route::delete('/admin/permohonan/{id}', [AdminPermohonanController::class, 'destroy'])
        ->name('admin.permohonan.destroy');
    
    Route::get('/admin/permohonan-export', [AdminPermohonanController::class, 'exportExcel'])
        ->name('admin.permohonan.export');

    Route::get('/admin/permohonan/export/pdf', [AdminPermohonanController::class, 'exportPdf']
        )->name('admin.permohonan.export.pdf');
    

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

    //route kategori
    Route::resource('admin/categories', CategoryController::class)->names([
    'index'   => 'admin.categories.index',
    'create'  => 'admin.categories.create',
    'store'   => 'admin.categories.store',
    'show'    => 'admin.categories.show',
    'edit'    => 'admin.categories.edit',
    'update'  => 'admin.categories.update',
    'destroy' => 'admin.categories.destroy',
    ]);

    //sub kategori
    // Rute untuk Subkategori
Route::resource('admin/subcategories', SubcategoryController::class)->names([
    'index'   => 'admin.subcategories.index',
    'create'  => 'admin.subcategories.create',
    'store'   => 'admin.subcategories.store',
    'show'    => 'admin.subcategories.show',
    'edit'    => 'admin.subcategories.edit',
    'update'  => 'admin.subcategories.update',
    'destroy' => 'admin.subcategories.destroy',
]);

Route::get('admin/categories/{category}/subcategories', [SubcategoryController::class, 'getSubcategories']);
Route::get('admin/categories/{categoryId}/subcategories', function ($categoryId) {
    $subcategories = Subcategory::where('category_id', $categoryId)->get();
    return response()->json(['subcategories' => $subcategories]);
});
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

   Route::get('skpd/categories/{category}/subcategories', [SubcategoryController::class, 'getSubcategories']);
   Route::get('skpd/categories/{categoryId}/subcategories', function ($categoryId) {
    $subcategories = Subcategory::where('category_id', $categoryId)->get();
    return response()->json(['subcategories' => $subcategories]);
});
});