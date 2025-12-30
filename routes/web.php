<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ObservationController; // Panggil Controller JSO
use App\Http\Controllers\CompanyController; //panggil controller perusahaan pelaksana
use App\Http\Controllers\K3lkEmployeeController; //panggil controller pegawai K3LK
use Illuminate\Support\Facades\Route;

// Halaman Depan (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('welcome');
});

// Halaman Khusus User yang Sudah Login
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [ObservationController::class, 'dashboard'])->name('dashboard');

    // ============================================================
    // MASTER DATA (K3LK & Vendor)
    // ============================================================
    
    // 1. Data Pegawai K3LK (Revisi: Diletakkan sebelum Perusahaan Pelaksana)
    Route::resource('k3lk_employees', K3lkEmployeeController::class);

    // 2. Data Perusahaan Pelaksana
    Route::resource('companies', CompanyController::class)->except(['show'])->names('companies'); 
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

    // ============================================================
    // DATA OBSERVASI
    // ============================================================
    
    // 2 Data Observasi & Formulir Input (Menggunakan Resource Route)
    Route::resource('observations', ObservationController::class)->except(['show']);
    
    // Rute Detail (Show)
    Route::get('/observations/{observation}', [ObservationController::class, 'show'])->name('observations.show');
    
    // ============================================================
    // PERBAIKAN STRUKTUR LAPORAN (Sesuai Rombakan 5 Fitur)
    // ============================================================
    
    // Rute Menu Laporan Utama
    Route::get('/laporan', function () {
        return view('reports.index'); 
    })->name('reports.index'); 

    // 1. Ringkasan & Bahaya (Gabungan sesuai permintaan dosen)
    Route::get('/laporan/rekapitulasi', [ObservationController::class, 'rekapitulasiJso'])->name('reports.rekapitulasi');
    
    // 2. Kinerja Vendor
    Route::get('/laporan/vendor', [ObservationController::class, 'laporanKinerjaVendor'])->name('reports.vendor');
    
    // 3. Profil Risiko Personel (Individu)
    Route::get('/laporan/individu', [ObservationController::class, 'laporanRiwayatIndividu'])->name('reports.individu');
    
    // 4. Audit Dokumen
    Route::get('/laporan/dokumen', [ObservationController::class, 'laporanKelengkapanDokumen'])->name('reports.dokumen');
    
    // 5. Verifikasi Evidence (Fitur Laporan ke-5 Baru)
    Route::get('/laporan/evidence', [ObservationController::class, 'laporanEvidence'])->name('reports.evidence');

    // Rute Cetak PDF
    Route::get('/laporan/cetak', [ObservationController::class, 'cetakLaporan'])->name('reports.cetak'); 
    
    // ============================================================

    // Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';