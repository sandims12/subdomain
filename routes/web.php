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

/*
|--------------------------------------------------------------------------
| A. AUTH / PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect('/login'));

Route::get('/login',    [AdminAuthController::class, 'index'])->name('login');
Route::post('/login',   [AdminAuthController::class, 'doLogin']);
Route::get('/register', [AdminAuthController::class, 'nampilnoregister'])->name('register');
Route::post('/register',[AdminAuthController::class, 'register']);
Route::post('/user/update-name', [AdminAuthController::class, 'updateName'])->name('user.updateName');
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AdminAuthController::class, 'showForgotForm'])->name('admin.password.request');
Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('admin.password.email');
Route::get('/reset-password/{token}', [AdminAuthController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('admin.password.update');

/*
|--------------------------------------------------------------------------
| B. ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // SKPD (CRUD manual)
    Route::get('/skpd',            [AdminSkpdController::class, 'index'])->name('skpd.index');
    Route::get('/skpd/create',     [AdminSkpdController::class, 'create'])->name('skpd.create');
    Route::post('/skpd',           [AdminSkpdController::class, 'store'])->name('skpd.store');
    Route::get('/skpd/{id}/edit',  [AdminSkpdController::class, 'edit'])->name('skpd.edit');
    Route::put('/skpd/{id}',       [AdminSkpdController::class, 'update'])->name('skpd.update');
    Route::delete('/skpd/{id}',    [AdminSkpdController::class, 'destroy'])->name('skpd.destroy');

    // Permohonan
    Route::get('/permohonan',              [AdminPermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('/permohonan/{id}',         [AdminPermohonanController::class, 'show'])->name('permohonan.show');
    Route::post('/permohonan/{id}/update', [AdminPermohonanController::class, 'updateStatus'])->name('permohonan.updateStatus');

    // Export (Excel & PDF)
    Route::get('/permohonan-export',        [AdminPermohonanController::class, 'exportExcel'])
        ->name('permohonan.export');          // route('admin.permohonan.export')
    Route::get('/permohonan/export/pdf',    [AdminPermohonanController::class, 'exportPdf'])
        ->name('permohonan.export.pdf');      // route('admin.permohonan.export.pdf')

    // Subdomain (resource)
    Route::resource('subdomain', AdminSubdomainController::class);

    // Categories (resource)
    Route::resource('categories', CategoryController::class);

    // Subcategories (resource)
    Route::resource('subcategories', SubcategoryController::class);

    // AJAX: ambil subkategori berdasarkan category
    Route::get('categories/{category}/subcategories',
        [SubcategoryController::class, 'getSubcategories']
    )->name('categories.subcategories');
});

/*
|--------------------------------------------------------------------------
| C. SKPD AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:skpd'])
    ->prefix('skpd')->name('skpd.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [SkpdDashboardController::class, 'index'])->name('dashboard');

    // Permohonan Subdomain
    Route::get('/permohonan/create', [SkpdPermohonanController::class, 'create'])->name('permohonan.create');
    Route::post('/permohonan',       [SkpdPermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/permohonan',        [SkpdPermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('/permohonan',                [SkpdPermohonanController::class,'index'])->name('permohonan.index');
    Route::get('/permohonan/{permohonan}/edit', [SkpdPermohonanController::class,'edit'])->name('permohonan.edit');
    Route::put('/permohonan/{permohonan}',      [SkpdPermohonanController::class,'update'])->name('permohonan.update');
    Route::delete('/permohonan/{permohonan}',   [SkpdPermohonanController::class,'destroy'])->name('permohonan.destroy');


    // (opsional) route lama tetap hidup tanpa nama
    Route::get('/permohonan-saya',   [SkpdPermohonanController::class, 'index']);
    Route::get('/permohonan/{id}', [SkpdPermohonanController::class, 'show'])->name('permohonan.show');


    // Daftar subdomain milik SKPD yang login
    Route::get('/subdomain', [SkpdSubdomainController::class, 'index'])->name('subdomain.index');

    // AJAX dependent dropdown
    Route::get('categories/{category}/subcategories',
        [SubcategoryController::class, 'getSubcategories']
    )->name('categories.subcategories');
});
