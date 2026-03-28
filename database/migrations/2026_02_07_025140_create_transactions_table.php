<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_member')->nullable()->constrained('members');
            $table->string('nomor_unik')->unique();
            
            // HAPUS ->after('nomor_unik') karena di CREATE TABLE tidak bisa pakai AFTER
            $table->string('jenis_transaksi')
                  ->default('produk')
                  ->comment('produk, visit, membership, produk_visit, produk_membership');
            
            $table->decimal('total_harga', 10, 2);
            $table->decimal('uang_bayar', 10, 2);
            $table->decimal('uang_kembali', 10, 2);
            $table->enum('metode_bayar', ['cash', 'debit', 'credit', 'qris'])->default('cash');
            $table->enum('status_transaksi', ['pending', 'success', 'cancelled'])->default('success');
            $table->text('catatan')->nullable();
            
            // HAPUS ->after('catatan') karena di CREATE TABLE tidak bisa pakai AFTER
            $table->json('data_tambahan')
                  ->nullable()
                  ->comment('Menyimpan data visit dan membership');            
                  
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};