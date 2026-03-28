<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->integer('durasi_hari');
            $table->decimal('harga', 10, 2);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_packages');
    }
};