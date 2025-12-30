<?php

// database/migrations/2025_12_15_XXXXXX_add_company_id_to_observations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            // BARIS KRUSIAL: Tambahkan foreign key company_id
            $table->foreignId('company_id')
                  ->nullable() // Dibuat nullable dulu agar data lama tidak error
                  ->after('perusahaan_pelaksana') // Letakkan setelah kolom lama
                  ->constrained('companies')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            // Hapus foreign key dan kolomnya jika rollback
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};