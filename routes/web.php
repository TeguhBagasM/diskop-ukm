<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgendaKegiatanController;
use App\Http\Controllers\Admin\IkuController;
use App\Http\Controllers\Admin\AnggaranController;
use App\Http\Controllers\Admin\DanaBergulirController;
use App\Http\Controllers\Admin\KoperasiController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\DokDiskopController;
use App\Http\Controllers\Admin\PegawaiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ================== ADMIN ROUTES ==================
Route::middleware(['isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', UserController::class);

    // Agenda Kegiatan
    Route::prefix('agenda')->name('agenda.')->group(function () {
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

    // Calendar
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [AgendaKegiatanController::class, 'calendar'])->name('calendar');
        Route::get('/agenda/{date}', [AgendaKegiatanController::class, 'getAgendaForDate'])->name('calendar.agenda');
    });

    // IKU
    Route::resource('iku', IkuController::class);

    // Realisasi Anggaran
    Route::resource('anggaran', AnggaranController::class);

    // Dana Bergulir
    Route::resource('danabergulir', DanaBergulirController::class);

    // Data Koperasi
    Route::resource('koperasi', KoperasiController::class);

    // Data UMKM
    Route::resource('umkm', UmkmController::class);

    // Dokumen Diskop
    Route::resource('dokdiskop', DokDiskopController::class);

    // Data Pegawai
    Route::resource('pegawai', PegawaiController::class);

    // tambahkan route admin lainnya di sini
});

// ================== USER ROUTES ==================
Route::middleware(['auth'])->group(function () {
    // Agenda Kegiatan (User - Read Only)
    Route::prefix('agenda')->name('agenda.')->group(function () {
        Route::get('/', [AgendaKegiatanController::class, 'index'])->name('index');
        Route::get('/{agenda}', [AgendaKegiatanController::class, 'show'])->name('show');
        Route::get('/api/json', [AgendaKegiatanController::class, 'getAgendaJson'])->name('api.json');
    });

    // tambahkan route user lainnya di sini
});
