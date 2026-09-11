<?php

use App\Http\Controllers\IndividualController;
use App\Http\Controllers\FamilyTreeController;
use App\Http\Controllers\MarriageController;
use App\Http\Controllers\SilsilahController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES (Read-Only)
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

// Silsilah
Route::get('/silsilah', [SilsilahController::class, 'index'])->name('silsilah.index');
Route::get('/silsilah/{id}', [SilsilahController::class, 'show'])->name('silsilah.show');
Route::get('/cari-hubungan', [SilsilahController::class, 'cariHubungan'])->name('silsilah.cari-hubungan');
Route::post('/cari-hubungan/find', [SilsilahController::class, 'findRelationship'])->name('silsilah.find-relationship');

// Pohon Keluarga
Route::get('/family-tree', [FamilyTreeController::class, 'index'])->name('family-tree.index');
Route::get('/api/family-tree', [FamilyTreeController::class, 'getTreeData'])->name('api.family-tree');

// Database Individu (read-only)
Route::get('/individuals', [IndividualController::class, 'index'])->name('individuals.index');
Route::get('/individuals/{individual}', [IndividualController::class, 'show'])->name('individuals.show');

// ============================================
// ADMIN AUTH ROUTES
// ============================================
Route::get('/panel-admin', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/panel-admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/panel-admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ============================================
// ADMIN PROTECTED ROUTES (CRUD)
// ============================================
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    // CRUD Individuals
    Route::get('/individuals', [IndividualController::class, 'index'])->name('individuals.index');
    Route::get('/individuals/create', [IndividualController::class, 'create'])->name('individuals.create');
    Route::post('/individuals', [IndividualController::class, 'store'])->name('individuals.store');
    Route::get('/individuals/{individual}/edit', [IndividualController::class, 'edit'])->name('individuals.edit');
    Route::put('/individuals/{individual}', [IndividualController::class, 'update'])->name('individuals.update');
    Route::delete('/individuals/{individual}', [IndividualController::class, 'destroy'])->name('individuals.destroy');

    // CRUD Marriages
    Route::get('/marriages/create/{individualId}', [MarriageController::class, 'create'])->name('marriages.create');
    Route::post('/marriages', [MarriageController::class, 'store'])->name('marriages.store');
    Route::get('/marriages/{marriage}/edit', [MarriageController::class, 'edit'])->name('marriages.edit');
    Route::put('/marriages/{marriage}', [MarriageController::class, 'update'])->name('marriages.update');
    Route::delete('/marriages/{marriage}', [MarriageController::class, 'destroy'])->name('marriages.destroy');
});
