<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Panggil helper Str untuk manipulasi string

class Company extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama',
        'alamat',
        'kontak',
        'email',
        'kode_perusahaan', 
    ];

    /**
     * DEFINISI HUBUNGAN (BARU)
     * Satu Perusahaan memiliki banyak Observasi
     */
    public function observations() // <-- BARU
    {
        // Company memiliki banyak Observation
        return $this->hasMany(Observation::class); 
    }
    
    /**
     * Helper untuk membuat kode unik dari nama perusahaan.
     * Contoh: PT. Mantap Jiwa -> MPJ
     */
    public static function generateCodeFromNama(string $nama): string
    {
        // 1. Bersihkan string (hapus PT., koma, dsb.)
        $cleanedName = preg_replace('/[^\w\s]/', '', $nama);
        $cleanedName = str_ireplace('PT', '', $cleanedName);
        $cleanedName = trim($cleanedName);

        // 2. Ambil inisial dari setiap kata
        $initials = Str::of($cleanedName)->split('/\s+/')->map(function ($word) {
            return Str::upper(Str::substr($word, 0, 1));
        })->implode('');

        // 3. Batasi inisial menjadi 4 huruf (atau sesuai kebutuhan, misal untuk kode MPJ)
        return Str::limit($initials, 4, ''); 
    }

    /**
     * Membuat kode unik yang pasti belum ada di database.
     */
    public static function generateUniqueCode(string $nama): string
    {
        // Ambil kode inisial dasar (misal: MPJ)
        $baseCode = self::generateCodeFromNama($nama);
        $code = $baseCode;
        $counter = 1;

        // Cek apakah kode sudah ada di database
        while (self::where('kode_perusahaan', $code)->exists()) {
            // Jika sudah ada, tambahkan angka counter (MPJ1, MPJ2, dst)
            $code = $baseCode . $counter;
            $counter++;
            
            // Batasi pengulangan untuk menghindari infinite loop
            if ($counter > 99) {
                // Jika sudah mencapai 99, tambahkan random string 
                $code = $baseCode . Str::random(3); 
                break;
            }
        }

        return $code;
    }
}