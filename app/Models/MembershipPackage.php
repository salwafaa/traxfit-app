<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'durasi_hari',
        'harga',
        'status'
    ];

    protected $casts = [
        'durasi_hari' => 'integer',
        'harga' => 'decimal:2',
        'status' => 'boolean',
    ];

    // Relasi dengan member
    public function members()
    {
        return $this->hasMany(Member::class, 'id_paket');
    }

    // Format harga
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Format durasi
    public function getDurasiFormattedAttribute()
    {
        if ($this->durasi_hari >= 365) {
            $tahun = floor($this->durasi_hari / 365);
            return $tahun . ' Tahun';
        } elseif ($this->durasi_hari >= 30) {
            $bulan = floor($this->durasi_hari / 30);
            return $bulan . ' Bulan';
        } else {
            return $this->durasi_hari . ' Hari';
        }
    }

    // Hitung harga per hari
    public function getHargaPerHariAttribute()
    {
        if ($this->durasi_hari > 0) {
            return $this->harga / $this->durasi_hari;
        }
        return 0;
    }
}