<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'auth/Login')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('surat', 'Surat')->name('surat');
    Route::inertia('arsip', 'Arsip')->name('arsip');
});
Route::get('/arsip/print/{agenda}', [ArsipController::class, 'print']);
Route::get('/arsip/print-attachment/{agenda}', [ArsipController::class, 'printAttachment']);

Route::get('/arsip-data', [ArsipController::class, 'index']);
Route::get('/dashboard-data', [DashboardController::class, 'index']);
Route::get('/agenda', [AgendaController::class, 'index']);
Route::post('/agenda/save', [AgendaController::class, 'store']);
Route::put('/agenda/{agenda}', [AgendaController::class, 'update']);
Route::get('/agenda/generate-number', [AgendaController::class, 'generateNomorAgenda']);
Route::post('/agenda/delete/{id}', [AgendaController::class, 'destroy'])
    ->name('agenda.destroy');
require __DIR__.'/settings.php';
