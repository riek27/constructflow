<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VariationController;

Route::redirect('/', '/login');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:view dashboard'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Projects
Route::middleware(['auth', 'permission:manage projects'])->group(function () {
    Route::resource('projects', ProjectController::class);
});

// Contracts
Route::middleware(['auth', 'permission:manage contracts'])->group(function () {
    Route::resource('contracts', ContractController::class);
});

Route::middleware(['auth', 'permission:manage variations'])->group(function () {
    Route::resource('variations', VariationController::class);
});

Route::middleware(['auth', 'permission:manage payments'])->group(function () {
    Route::resource('payments', PaymentController::class);
});

Route::middleware(['auth', 'permission:manage procurement'])->group(function () {
    Route::resource('procurements', ProcurementController::class);
});

Route::middleware(['auth', 'permission:manage documents'])->group(function () {
    Route::resource('documents', DocumentController::class);
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
});

Route::middleware(['auth', 'permission:manage reports'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
});

Route::middleware(['auth', 'permission:view activity logs'])->group(function () {
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});

// Users management
Route::middleware(['auth', 'permission:manage users'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::redirect('/register', '/login');
require __DIR__.'/auth.php';