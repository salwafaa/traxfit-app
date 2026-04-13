<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom via_transaksi ke tabel member_checkin.
     * Kolom ini menandai apakah check-in dibuat otomatis
     * karena member melakukan transaksi/perpanjangan membership hari itu.
     */
    public function up(): void
    {
        Schema::table('member_checkin', function (Blueprint $table) {
            $table->boolean('via_transaksi')
                  ->default(false)
                  ->after('id_kasir')
                  ->comment('true = check-in otomatis dari transaksi membership');
        });
    }

    public function down(): void
    {
        Schema::table('member_checkin', function (Blueprint $table) {
            $table->dropColumn('via_transaksi');
        });
    }
};