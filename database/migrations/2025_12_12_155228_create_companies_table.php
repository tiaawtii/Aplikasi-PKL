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
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        
        // --- START: KOLOM BARU UNTUK MASTER DATA PERUSAHAAN ---
        $table->string('nama', 100);
        $table->text('alamat')->nullable();
        $table->string('kontak')->nullable(); // Nomor telepon atau nama PIC
        $table->string('email')->nullable(); 
        // --- END: KOLOM BARU ---

        $table->timestamps(); // created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
