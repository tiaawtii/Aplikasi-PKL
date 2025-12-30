<?php

// database/migrations/YYYY_MM_DD_create_work_units_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_units', function (Blueprint $table) {
            $table->id();
            $table->string('nama_unit')->unique(); // Nama Unit Pekerjaan
            $table->string('kode_unit', 10)->nullable()->unique(); // Kode Singkat Unit (Opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_units');
    }
};