<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';
    
    protected $fillable = [
        'id_transaction',
        'id_product',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'qty' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relasi dengan transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction');
    }

    // Relasi dengan produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}