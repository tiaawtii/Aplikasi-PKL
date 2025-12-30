<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::table('observations', function (Blueprint $table) {
        // Kolom untuk menyimpan path file foto
        $table->string('bukti_dokumen_path')->nullable()->after('dokumen_tersedia');
    });
}

public function down(): void
{
    Schema::table('observations', function (Blueprint $table) {
        $table->dropColumn('bukti_dokumen_path');
    });
}

};
