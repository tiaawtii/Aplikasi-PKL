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
        // Menambahkan kolom untuk menyimpan path foto review di bawah kolom review_bersama_pekerja
        $table->string('foto_review_path')->nullable()->after('review_bersama_pekerja');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            //
        });
    }
};
