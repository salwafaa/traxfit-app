<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_checkin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_member')->constrained('members');
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->foreignId('id_kasir')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_checkin');
    }
};