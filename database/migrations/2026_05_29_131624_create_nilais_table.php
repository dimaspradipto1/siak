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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->cascadeOnDelete();
            
            // Lingkup Materi 1
            $table->decimal('lm1_tp1', 5, 2)->nullable();
            $table->decimal('lm1_tp2', 5, 2)->nullable();
            $table->decimal('lm1_tp3', 5, 2)->nullable();
            $table->decimal('lm1_tp4', 5, 2)->nullable();
            $table->decimal('lm1', 5, 2)->nullable();

            // Lingkup Materi 2
            $table->decimal('lm2_tp1', 5, 2)->nullable();
            $table->decimal('lm2_tp2', 5, 2)->nullable();
            $table->decimal('lm2_tp3', 5, 2)->nullable();
            $table->decimal('lm2_tp4', 5, 2)->nullable();
            $table->decimal('lm2', 5, 2)->nullable();

            // Lingkup Materi 3
            $table->decimal('lm3_tp1', 5, 2)->nullable();
            $table->decimal('lm3_tp2', 5, 2)->nullable();
            $table->decimal('lm3_tp3', 5, 2)->nullable();
            $table->decimal('lm3_tp4', 5, 2)->nullable();
            $table->decimal('lm3', 5, 2)->nullable();

            // Lingkup Materi 4
            $table->decimal('lm4_tp1', 5, 2)->nullable();
            $table->decimal('lm4_tp2', 5, 2)->nullable();
            $table->decimal('lm4_tp3', 5, 2)->nullable();
            $table->decimal('lm4_tp4', 5, 2)->nullable();
            $table->decimal('lm4', 5, 2)->nullable();

            // Lingkup Materi 5
            $table->decimal('lm5_tp1', 5, 2)->nullable();
            $table->decimal('lm5_tp2', 5, 2)->nullable();
            $table->decimal('lm5_tp3', 5, 2)->nullable();
            $table->decimal('lm5_tp4', 5, 2)->nullable();
            $table->decimal('lm5', 5, 2)->nullable();

            // Weighted scores
            $table->decimal('nilai_harian', 5, 2)->nullable();
            $table->decimal('nilai_mid', 5, 2)->nullable();
            $table->decimal('nilai_mid_plus', 5, 2)->nullable();
            $table->decimal('nilai_pas', 5, 2)->nullable();
            $table->decimal('nilai_pas_plus', 5, 2)->nullable();
            $table->decimal('nilai_raport', 5, 2)->nullable();

            // Main fallback columns
            $table->decimal('nilai', 5, 2)->nullable();
            $table->string('predikat')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
