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
        Schema::table('jabatans', function (Blueprint $table) {
            if (!Schema::hasColumn('jabatans', 'kode_jabatan')) {
                $table->string('kode_jabatan')->nullable()->after('id');
            }
            if (!Schema::hasColumn('jabatans', 'status')) {
                $table->string('status')->default('Aktif')->after('keterangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jabatans', function (Blueprint $table) {
            if (Schema::hasColumn('jabatans', 'kode_jabatan')) {
                $table->dropColumn('kode_jabatan');
            }
            if (Schema::hasColumn('jabatans', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
