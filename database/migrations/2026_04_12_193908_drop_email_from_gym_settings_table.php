<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gym_settings', function (Blueprint $table) {
            // Cek apakah kolom email ada, jika ada maka hapus
            if (Schema::hasColumn('gym_settings', 'email')) {
                $table->dropColumn('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gym_settings', function (Blueprint $table) {
            // Untuk rollback, tambahkan kembali kolom email
            $table->string('email')->nullable()->after('telepon');
        });
    }
};