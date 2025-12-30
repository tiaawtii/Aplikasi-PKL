<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('observations', function (Blueprint $table) {
        // Menambahkan kolom relasi ke tabel pegawai K3LK
        $table->unsignedBigInteger('k3lk_employee_id')->nullable()->after('id');
        
        // Membuat relasi foreign key
        $table->foreign('k3lk_employee_id')
              ->references('id')
              ->on('k3lk_employees')
              ->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('observations', function (Blueprint $table) {
        $table->dropForeign(['k3lk_employee_id']);
        $table->dropColumn('k3lk_employee_id');
    });
}
};
