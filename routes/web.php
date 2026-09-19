<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;

// Public Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Protected Admin Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('committees', CommitteeController::class);
    Route::resource('members', MemberController::class);

    Route::get('donations/{donation}/receipt', [DonationController::class, 'receipt'])->name('donations.receipt');
    Route::resource('donations', DonationController::class);

    Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.export-csv');
});
