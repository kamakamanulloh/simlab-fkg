<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\LimbahController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\QualityController;
use App\Http\Controllers\LabWasteController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\DosenDashboardController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\MahasiswaReservationController;
use App\Http\Controllers\MahasiswaLoanController;
use App\Http\Controllers\MahasiswaLogbookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'loginAjax'])->name('login.ajax');
});

// auth
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
  Route::get('/jadwal', [JadwalController::class, 'index'])
        ->name('jadwal');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
  Route::get('/inventori', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventori/store', [InventoryController::class, 'store'])->name('inventory.store');
      Route::get('/inventori/export-pdf', [InventoryController::class, 'exportPdf'])
        ->name('inventory.export_pdf');
         // download template excel
    Route::get('/inventori/template/{type}', [InventoryController::class, 'downloadTemplate'])
        ->whereIn('type', ['peralatan', 'bahan'])
        ->name('inventory.template');
Route::get('/pemeliharaan', [MaintenanceController::class, 'index'])
        ->name('pemeliharaan.index');
    // import excel
    Route::post('/inventori/import', [InventoryController::class, 'importExcel'])
        ->name('inventory.import');
      Route::get('/peminjaman', [LoanController::class, 'index'])
    ->name('peminjaman.index');
  Route::post('/peminjaman', [LoanController::class, 'store'])
        ->name('peminjaman.store');
// Rute untuk Logbook Digital
    Route::get('/logbook', [App\Http\Controllers\LogbookController::class, 'index'])
        ->name('logbook.index');
          Route::get('/ajax/borrowers', [LoanController::class, 'searchBorrowers'])
        ->name('borrowers.search');
        // Route Modul Limbah & K3
    Route::get('/limbah', [LimbahController::class, 'index'])->name('limbah.index');
    Route::post('/insiden/store', [LimbahController::class, 'store'])->name('insiden.store');
   Route::get('/insiden/list', [LimbahController::class, 'list']);
    Route::get('/insiden/generate-id', [LimbahController::class, 'generateId']);
Route::get('/insiden/{id}', [LimbahController::class, 'show']);
Route::get('/insiden/detail/{id_insiden}', [LimbahController::class, 'showByKode']);
Route::get('/jadwal/by-date', [JadwalController::class, 'byDate']);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
   // Route baru untuk export PDF
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export_pdf');
    Route::get('/quality-audit', [QualityController::class, 'index'])->name('quality-audit.index');
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
        Route::get('/quality/document/{id}/view', [QualityController::class, 'viewDocument'])->name('quality.document.view');
    Route::get('/quality/document/{id}/download', [QualityController::class, 'downloadDocument'])->name('quality.document.download');
        Route::post('/quality/document/store', [QualityController::class, 'storeDocument'])->name('quality.store-document');

Route::post('/lab-waste/store', [LabWasteController::class, 'store'])
    ->name('lab-waste.store');
Route::get('/jadwal/{id}', [JadwalController::class, 'show']);
Route::put('/jadwal/{id}', [JadwalController::class, 'update']);
Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy']);
    Route::get('/pelatihan', [PelatihanController::class, 'index'])->name('pelatihan.index');

    Route::post('/pelatihan/store', [PelatihanController::class, 'store'])->name('pelatihan.store');

    Route::get('/pelatihan/{id}', [PelatihanController::class, 'show']);

    Route::put('/pelatihan/{id}', [PelatihanController::class, 'update']);
    Route::post('/analisis-biaya/store', [MaintenanceController::class, 'storeCost'])
    ->name('analisis.store');
        Route::get('/dosen/dashboard', 
        [DosenDashboardController::class, 'index']
    )->name('dosen.dashboard');
    Route::get('/mahasiswa/dashboard',
        [MahasiswaDashboardController::class, 'index']
    )->name('mahasiswa.dashboard');

    Route::get('/mahasiswa/jadwal/by-date',
        [MahasiswaDashboardController::class, 'jadwalByDate']
    );
    Route::post('/mahasiswa/reservasi/store', 
    [MahasiswaReservationController::class, 'store']
)->middleware('auth');
Route::post('/mahasiswa/peminjaman/store',
    [MahasiswaLoanController::class, 'store']
)->middleware('auth');
Route::get('/mahasiswa/peminjaman/list',
    [MahasiswaLoanController::class, 'list']
)->middleware('auth');
Route::post('/mahasiswa/peminjaman/return',
    [\App\Http\Controllers\MahasiswaLoanController::class, 'returnLoan']
)->middleware('auth');
 Route::get('/mahasiswa/pengembalian/detail/{loan}', 
        [MahasiswaLoanController::class, 'detailPengembalian']
    );
    
    Route::post('/mahasiswa/logbook/store',
        [MahasiswaLogbookController::class, 'store']);
        Route::get('/mahasiswa/logbook/list', [MahasiswaLogbookController::class, 'list']);
        });




   

// optional: redirect root ke login atau dashboard
Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});