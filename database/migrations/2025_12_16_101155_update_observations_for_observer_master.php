<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            // 1. Hapus kolom 'nama_observer' yang lama (berbentuk teks)
            $table->dropColumn('nama_observer'); 
            
            // 2. Tambahkan Foreign Key baru (observer_id)
            $table->foreignId('observer_id')
                  ->nullable() // NULLABLE agar data observasi lama tidak rusak
                  ->after('work_unit_id') // Lokasi kolom di tabel (opsional)
                  ->constrained('observers') // Merujuk ke tabel observers
                  ->onDelete('set null'); // Jika Observer dihapus, data observasi lama tetap ada (ID di set NULL)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            // Hapus Foreign Key dan kolom observer_id saat rollback
            $table->dropForeign(['observer_id']);
            $table->dropColumn('observer_id');
            
            // Tambahkan kembali kolom 'nama_observer' jika sewaktu-waktu rollback
            $table->string('nama_observer')->nullable();
        });
    }
};