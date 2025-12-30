<?php

// database/migrations/2025_12_15_XXXXXX_make_perusahaan_pelaksana_nullable.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            // BARIS KRUSIAL: Ubah kolom 'perusahaan_pelaksana' menjadi boleh NULL
            $table->string('perusahaan_pelaksana')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            // Jika rollback, kembalikan kolom menjadi wajib diisi (NOT NULL)
            // (Asumsi kolom ini sebelumnya adalah string biasa, bukan enum)
            $table->string('perusahaan_pelaksana')->nullable(false)->change();
        });
    }
};