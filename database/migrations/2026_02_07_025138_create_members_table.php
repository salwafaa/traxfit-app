<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
    $table->id();
    $table->string('kode_member')->unique();

    $table->string('nama');
    $table->string('telepon')->nullable();
    $table->text('alamat')->nullable();

    $table->string('jenis_member')->nullable();

    $table->foreignId('id_paket')
        ->nullable()
        ->constrained('membership_packages')
        ->nullOnDelete();
    $table->string('no_identitas')->unique()->nullable();
    $table->enum('jenis_identitas', ['KTP','SIM'])->nullable();
    $table->date('tgl_lahir')->nullable();
    $table->string('foto_identitas')->nullable();
    $table->date('tgl_daftar');
    $table->date('tgl_expired');
    $table->enum('status', ['active','expired','suspended'])
        ->default('active');
    $table->timestamps();
    $table->index(['nama','telepon']);
});

    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};