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
        Schema::table('pegawais', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawais', 'golongan')) {
                $table->string('golongan')->nullable()->after('jabatan');
            }
            if (!Schema::hasColumn('pegawais', 'pendidikan_terakhir')) {
                $table->string('pendidikan_terakhir')->nullable()->after('golongan');
            }
            if (!Schema::hasColumn('pegawais', 'status')) {
                $table->string('status')->default('Aktif')->after('pendidikan_terakhir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            if (Schema::hasColumn('pegawais', 'golongan')) {
                $table->dropColumn('golongan');
            }
            if (Schema::hasColumn('pegawais', 'pendidikan_terakhir')) {
                $table->dropColumn('pendidikan_terakhir');
            }
            if (Schema::hasColumn('pegawais', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
