<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_product')->constrained('products');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->integer('qty');
            $table->text('keterangan')->nullable();
            $table->foreignId('id_user')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_log');
    }
};