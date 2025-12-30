<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WorkUnit; 
use App\Models\Company; 
use App\Models\K3lkEmployee; 

class Observation extends Model
{
    use HasFactory;

    /**
     * Supaya kita bisa simpan data langsung sekaligus.
     * Menggunakan guarded kosong berarti semua kolom diizinkan (Mass Assignment).
     * Dengan ini, kolom 'no_wp' akan otomatis tersimpan selama dikirim dari Controller.
     */
    protected $guarded = [];

    /**
     * Supaya kolom data otomatis dikonversi ke tipe data yang sesuai saat diakses.
     */
    protected $casts = [
        'dokumen_tersedia' => 'array',
        // Tambahkan cast untuk kolom tanggal agar Carbon instance
        'tanggal' => 'date', 
        'tanggal_observasi' => 'date', 
    ];

    /**
     * DEFINISI HUBUNGAN
     * Satu Observasi dimiliki oleh satu Perusahaan (company_id)
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    /**
     * DEFINISI HUBUNGAN
     * Satu Observasi dimiliki oleh satu Unit Pekerjaan (work_unit_id)
     */
    public function workUnit()
    {
        return $this->belongsTo(WorkUnit::class);
    }

    /**
     * DEFINISI HUBUNGAN
     * Satu Observasi dimiliki oleh satu Pegawai K3LK (k3lk_employee_id)
     * Ini yang menyambungkan ke Master Data Pegawai K3LK (Observer)
     */
    public function observer()
    {
        // Kita arahkan ke model K3lkEmployee dengan foreign key k3lk_employee_id
        return $this->belongsTo(K3lkEmployee::class, 'k3lk_employee_id');
    }
}