<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    use HasFactory;

    protected $table = 'stok_log';
    
    protected $fillable = [
        'id_product',
        'tipe',
        'qty',
        'keterangan',
        'id_user'
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['tipe'])) {
            $query->where('tipe', $filters['tipe']);
        }
        
        if (isset($filters['product'])) {
            $query->where('id_product', $filters['product']);
        }
        
        if (isset($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }
        
        if (isset($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }
        
        return $query;
    }
}