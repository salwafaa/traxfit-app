<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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