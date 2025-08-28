<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgendaKegiatanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/produk', [App\Http\Controllers\HomeController::class, 'produk'])->name('products.index');

// Admin Routes
Route::middleware(['isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('admin/users', UserController::class);

    // Agenda Kegiatan Routes (Admin Only)
    Route::prefix('admin/agenda')->name('admin.agenda.')->group(function () {
        Route::get('/', [AgendaKegiatanController::class, 'index'])->name('index');
        Route::get('/create', [AgendaKegiatanController::class, 'create'])->name('create');
        Route::post('/', [AgendaKegiatanController::class, 'store'])->name('store');
        Route::get('/{agenda}', [AgendaKegiatanController::class, 'show'])->name('show');
        Route::get('/{agenda}/edit', [AgendaKegiatanController::class, 'edit'])->name('edit');
        Route::put('/{agenda}', [AgendaKegiatanController::class, 'update'])->name('update');
        Route::delete('/{agenda}', [AgendaKegiatanController::class, 'destroy'])->name('destroy');
        Route::patch('/{agenda}/status', [AgendaKegiatanController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/export/excel', [AgendaKegiatanController::class, 'export'])->name('export.excel');
        Route::get('/api/json', [AgendaKegiatanController::class, 'getAgendaJson'])->name('api.json');
    });

    // tambahkan route admin lainnya di sini
});

// User Routes
Route::middleware(['auth'])->group(function () {
    // Agenda Kegiatan Routes (User - Read Only)
    Route::prefix('agenda')->name('agenda.')->group(function () {
        Route::get('/', [AgendaKegiatanController::class, 'index'])->name('index');
        Route::get('/{agenda}', [AgendaKegiatanController::class, 'show'])->name('show');
        Route::get('/api/json', [AgendaKegiatanController::class, 'getAgendaJson'])->name('api.json');
    });

    // tambahkan route user lainnya di sini
});
