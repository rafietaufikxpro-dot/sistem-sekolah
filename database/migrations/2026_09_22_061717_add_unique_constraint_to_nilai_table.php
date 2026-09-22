<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            // Mencegah duplikat nilai untuk kombinasi siswa + semester + tahun_ajaran + jenis_nilai
            $table->unique(['siswa_id', 'semester', 'tahun_ajaran', 'jenis_nilai'], 'nilai_unique');
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropUnique('nilai_unique');
        });
    }
};
