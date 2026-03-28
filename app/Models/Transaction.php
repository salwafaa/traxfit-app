<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_member',
        'nomor_unik',
        'jenis_transaksi', // BARU
        'total_harga',
        'uang_bayar',
        'uang_kembali',
        'metode_bayar',
        'status_transaksi',
        'catatan',
        'data_tambahan', // BARU
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'uang_bayar' => 'decimal:2',
        'uang_kembali' => 'decimal:2',
        'data_tambahan' => 'array', // PENTING: biar otomatis jadi array
    ];

    // Relasi dengan user/kasir
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi dengan member
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    // Relasi dengan detail transaksi
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'id_transaction');
    }

    // HELPER FUNCTIONS UNTUK CEK JENIS TRANSAKSI
    public function isProdukOnly()
    {
        return $this->jenis_transaksi === 'produk';
    }

    public function isVisitOnly()
    {
        return $this->jenis_transaksi === 'visit';
    }

    public function isMembershipOnly()
    {
        return $this->jenis_transaksi === 'membership';
    }

    public function isProdukDanVisit()
    {
        return $this->jenis_transaksi === 'produk_visit';
    }

    public function isProdukDanMembership()
    {
        return $this->jenis_transaksi === 'produk_membership';
    }

    // HELPER UNTUK AKSES DATA VISIT
    public function getDataVisitAttribute()
    {
        if ($this->isVisitOnly() || $this->isProdukDanVisit()) {
            return [
                'harga_visit' => $this->data_tambahan['harga_visit'] ?? 0,
                'tgl_visit' => $this->data_tambahan['tgl_visit'] ?? null,
            ];
        }
        return null;
    }

    // HELPER UNTUK AKSES DATA MEMBERSHIP
    public function getDataMembershipAttribute()
    {
        if ($this->isMembershipOnly() || $this->isProdukDanMembership()) {
            return [
                'id_paket' => $this->data_tambahan['id_paket'] ?? null,
                'nama_paket' => $this->data_tambahan['nama_paket'] ?? null,
                'durasi_hari' => $this->data_tambahan['durasi_hari'] ?? 0,
                'harga_paket' => $this->data_tambahan['harga_paket'] ?? 0,
                'tgl_mulai' => $this->data_tambahan['tgl_mulai'] ?? null,
                'tgl_selesai' => $this->data_tambahan['tgl_selesai'] ?? null,
            ];
        }
        return null;
    }

    // Generate nomor unik
    public static function generateNomorUnik()
    {
        $prefix = 'TRX' . date('Ymd');
        
        $lastTransaction = self::where('nomor_unik', 'like', $prefix . '%')
            ->orderBy('nomor_unik', 'desc')
            ->first();
        
        if ($lastTransaction) {
            $lastNumber = intval(substr($lastTransaction->nomor_unik, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . $newNumber;
    }
}