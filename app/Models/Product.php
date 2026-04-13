<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'kategori',
        'status',
        'deskripsi'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'kategori', 'id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'id_product');
    }

    public function stockLogs()
    {
        return $this->hasMany(StokLog::class, 'id_product');
    }
}