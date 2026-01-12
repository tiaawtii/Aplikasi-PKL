<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ObservationController; // Panggil Controller JSO
use App\Http\Controllers\CompanyController; // panggil controller perusahaan pelaksana
use App\Http\Controllers\K3lkEmployeeController; // panggil controller pegawai K3LK
use App\Http\Controllers\UserController; // Panggil Controller User Management
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
    // FITUR TESTING (Pindah Role & Loncat Akun)
    // ============================================================
    Route::post('/switch-role', [UserController::class, 'switchRole'])->name('switch.role');
    
    // Rute Baru untuk Loncat Akun (Impersonate) berdasarkan ID User
    Route::get('/impersonate/{id}', [UserController::class, 'impersonate'])->name('users.impersonate');

    // ============================================================
    // MASTER DATA (Akses Lihat: Admin & User | Akses Edit: Khusus Admin)
    // ============================================================
    
    // PERBAIKAN: Route Create diletakkan DI ATAS agar tidak dianggap sebagai ID (Mencegah Error show)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/k3lk_employees/create', [K3lkEmployeeController::class, 'create'])->name('k3lk_employees.create');
        Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    });

    // Rute Lihat Daftar (Admin & User)
    Route::get('/k3lk_employees', [K3lkEmployeeController::class, 'index'])->name('k3lk_employees.index');
    Route::get('/k3lk_employees/{k3lk_employee}', [K3lkEmployeeController::class, 'show'])->name('k3lk_employees.show');

    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

    // KHUSUS ADMIN (Edit, Update, Hapus)
    Route::middleware(['role:admin'])->group(function () {
        
        // Resource untuk Pegawai & Perusahaan (Aksi modifikasi data selain create, index, show)
        Route::resource('k3lk_employees', K3lkEmployeeController::class)->except(['index', 'show', 'create']);
        Route::resource('companies', CompanyController::class)->except(['index', 'show', 'create'])->names('companies'); 
        
        // Manajemen User (Tambah Role & Edit User)
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
        
    });

    // ============================================================
    // DATA OBSERVASI (Akses: Admin & User)
    // ============================================================
    
    // Data Observasi & Formulir Input (Menggunakan Resource Route)
    Route::resource('observations', ObservationController::class)->except(['show']);
    
    // Rute Detail (Show)
    Route::get('/observations/{observation}', [ObservationController::class, 'show'])->name('observations.show');
    
    // ============================================================
    // PERBAIKAN STRUKTUR LAPORAN (Akses: Admin & User)
    // ============================================================
    
    // Rute Menu Laporan Utama
    Route::get('/laporan', function () {
        return view('reports.index'); 
    })->name('reports.index'); 

    // 1. Ringkasan & Bahaya
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