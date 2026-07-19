<?php

use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\AturanPinjamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PinjamanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login-proses', [AuthController::class, 'loginProses'])
    ->name('login.proses');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');


    /*
    |--------------------------------------------------------------------------
    | NASABAH
    |--------------------------------------------------------------------------
    */

    Route::resource('nasabah', NasabahController::class);
    Route::put(
        '/nasabah-restore/{id}',
        [NasabahController::class, 'restore']
    )->name('nasabah.restore');

    Route::delete(
        '/nasabah-force-delete/{id}',
        [NasabahController::class, 'forceDelete']
    )->name('nasabah.forceDelete');

    /*
    |--------------------------------------------------------------------------
    | PINJAMAN
    |--------------------------------------------------------------------------
    */

    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('aturan-pinjaman', AturanPinjamanController::class);

    /*
    |--------------------------------------------------------------------------
    | ANGSURAN
    |--------------------------------------------------------------------------
    */

    Route::resource('angsuran', AngsuranController::class);
    Route::post(
        '/angsuran/{id}/bayar',
        [AngsuranController::class, 'bayar']
    )->name('angsuran.bayar');
    Route::get('/angsuran/tunggakan', [AngsuranController::class, 'tunggakan'])
        ->name('angsuran.tunggakan');
    Route::post('/angsuran/kirim-wa/{id}', [AngsuranController::class, 'kirimWa'])
        ->name('angsuran.kirimWa');

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::get('/laporan/nasabah/pdf', [LaporanController::class, 'pdfNasabah'])
    ->name('laporan.nasabah.pdf');

    Route::get('/laporan/pinjaman/pdf', [LaporanController::class, 'pdfPinjaman'])
        ->name('laporan.pinjaman.pdf');

    Route::get('/laporan/angsuran/pdf', [LaporanController::class, 'pdfAngsuran'])
        ->name('laporan.angsuran.pdf');

    Route::get('/laporan/tunggakan/pdf', [LaporanController::class, 'pdfTunggakan'])
    ->name('laporan.tunggakan.pdf');

    Route::get('/laporan/pelunasan/pdf', [LaporanController::class, 'pdfPelunasan'])
    ->name('laporan.pelunasan.pdf');
    /*
    |--------------------------------------------------------------------------
    | PENGGUNA
    |--------------------------------------------------------------------------
    */

    Route::resource('pengguna', PenggunaController::class);
    Route::get('/profil', [PenggunaController::class, 'profil'])
        ->name('pengguna.profil');
    Route::put('/profil/update', [PenggunaController::class, 'updateProfil'])
        ->name('pengguna.updateProfil');
    Route::post('/profil/update-password', [PenggunaController::class, 'updatePassword'])
        ->name('pengguna.updatePassword');
});
