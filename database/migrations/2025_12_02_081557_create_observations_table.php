<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            
            // 1. Data Pekerjaan
            $table->string('jenis_pekerjaan');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('lokasi_pekerjaan');
            $table->string('perusahaan_pelaksana');
            
            // 2. Personel
            $table->string('nama_personel_diobservasi');
            $table->string('nama_observer');
            
            // 3. Dokumen (SOP, JSA, IK, dll - simpan sbg JSON)
            $table->json('dokumen_tersedia'); 
            
            // 4. Hasil Observasi
            $table->enum('dokumen_dilaksanakan_baik', ['Ya', 'Tidak']);
            $table->text('catatan')->nullable();
            $table->text('unsafe_actions_conditions')->nullable();
            
            // 5. Review & Rekomendasi
            $table->enum('review_bersama_pekerja', ['Ya', 'Tidak']);
            $table->text('review_disampaikan')->nullable();
            $table->text('rekomendasi_perbaikan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};