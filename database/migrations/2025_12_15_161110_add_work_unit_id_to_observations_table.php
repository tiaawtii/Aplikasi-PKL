<?php

// database/migrations/YYYY_MM_DD_add_work_unit_id_to_observations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->foreignId('work_unit_id')
                  ->nullable() // Opsional, agar data lama tidak error
                  ->after('company_id') // Tempatkan setelah company_id
                  ->constrained('work_units') // Terhubung ke tabel work_units
                  ->onDelete('set null'); // Jika unit dihapus, data observasi tetap ada
        });
    }

    public function down(): void
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->dropForeign(['work_unit_id']);
            $table->dropColumn('work_unit_id');
        });
    }
};