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
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mapel')->nullable();
            $table->string('nama_mata_pelajaran')->nullable();
            $table->integer('kkm')->nullable();
            $table->text('tp_optimal')->nullable();
            $table->text('tp_peningkatan')->nullable();
            
            // Add schedule relation columns
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajarans')->cascadeOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->cascadeOnDelete();
            $table->foreignId('guru_id')->nullable()->constrained('gurus')->cascadeOnDelete();
            $table->string('hari_mengajar')->nullable();
            $table->string('jam_mengajar')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajarans');
    }
};
