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
        Schema::table('orang_tuas', function (Blueprint $table) {
            $table->string('nomor_wa_ibu')->nullable()->after('nomor_wa');
            $table->string('email')->nullable()->after('pekerjaan_ibu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orang_tuas', function (Blueprint $table) {
            $table->dropColumn(['nomor_wa_ibu', 'email']);
        });
    }
};
