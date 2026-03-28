<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gym_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gym');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable(); // TAMBAHKAN EMAIL
            $table->string('logo')->nullable(); // TAMBAHKAN LOGO
            $table->text('footer_struk')->nullable();
            
            // HAPUS 'after' karena ini CREATE TABLE, bukan ALTER TABLE
            $table->decimal('harga_visit', 10, 2)->default(25000)->comment('Harga visit harian');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gym_settings');
    }
};