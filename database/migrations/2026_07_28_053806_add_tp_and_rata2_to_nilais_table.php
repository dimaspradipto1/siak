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
        Schema::table('nilais', function (Blueprint $table) {
            $table->decimal('nilai_rata2', 5, 2)->nullable()->after('nilai_pas_plus');
            $table->text('tp_optimal')->nullable()->after('nilai_raport');
            $table->text('tp_perlu_peningkatan')->nullable()->after('tp_optimal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn(['nilai_rata2', 'tp_optimal', 'tp_perlu_peningkatan']);
        });
    }
};
