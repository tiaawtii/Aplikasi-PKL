<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('observations', function (Blueprint $blueprint) {
            // Menambahkan kolom no_wp setelah kolom dokumen_tersedia
            $blueprint->string('no_wp', 100)->nullable()->after('dokumen_tersedia');
        });
    }

    public function down()
    {
        Schema::table('observations', function (Blueprint $blueprint) {
            $blueprint->dropColumn('no_wp');
        });
    }
};