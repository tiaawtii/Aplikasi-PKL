<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class K3lkEmployee extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'k3lk_employees';

    // Kolom yang diizinkan untuk diisi manual
    protected $fillable = [
        'nip', 
        'nama_pegawai', 
        'jabatan'
    ];

    /**
     * Relasi ke tabel Observation.
     * Ini yang akan menyambungkan data pegawai ke form observasi sebagai pengamat (observer).
     */
    public function observations()
    {
        return $this->hasMany(Observation::class, 'observer_id');
    }
}