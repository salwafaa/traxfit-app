<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';
    
    protected $fillable = [
        'kode_member',
        'nama',
        'telepon',
        'alamat',
        'jenis_member',
        'id_paket',
        'no_identitas',
        'jenis_identitas',
        'tgl_lahir',
        'foto_identitas',
        'tgl_daftar',
        'tgl_expired',
        'status',
        'created_by'
    ];

    protected $casts = [
        'tgl_daftar' => 'date',
        'tgl_expired' => 'date',
        'tgl_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($member) {
            // Generate kode member unik
            $year = date('Y');
            $month = date('m');
            $lastMember = Member::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->orderBy('id', 'desc')
                ->first();
            
            if ($lastMember) {
                $lastNumber = intval(substr($lastMember->kode_member, -4));
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }
            
            $member->kode_member = 'MBR-' . $year . $month . '-' . $newNumber;
            
            // Set tgl_daftar jika tidak ada
            if (!$member->tgl_daftar) {
                $member->tgl_daftar = now();
            }
        });

        // Update status otomatis sebelum menyimpan
        static::saving(function ($member) {
            if ($member->tgl_expired) {
                $today = now()->startOfDay();
                $expired = Carbon::parse($member->tgl_expired)->startOfDay();
                
                // Auto update status berdasarkan tanggal expired
                if ($expired < $today) {
                    $member->status = 'expired';
                }
            }
        });
    }

    // Relasi dengan paket membership
    public function package()
    {
        return $this->belongsTo(MembershipPackage::class, 'id_paket');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_member');
    }

    // Relasi dengan checkin
    public function checkins()
    {
        return $this->hasMany(MemberCheckin::class, 'id_member');
    }

    // Scope untuk member aktif - DIPERBAIKI
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->whereDate('tgl_expired', '>=', now()->toDateString());
    }

    // Scope untuk member expired - DIPERBAIKI
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                    ->orWhereDate('tgl_expired', '<', now()->toDateString());
    }

    // Cek apakah member aktif - DIPERBAIKI
    public function getIsActiveAttribute()
    {
        if (!$this->tgl_expired) {
            return false;
        }
        
        $today = now()->startOfDay();
        $expired = Carbon::parse($this->tgl_expired)->startOfDay();
        
        return $this->status == 'active' && $expired >= $today;
    }

    // Hitung sisa hari - DIPERBAIKI
    public function getSisaHariAttribute()
    {
        if (!$this->tgl_expired) {
            return 0;
        }
        
        $today = now()->startOfDay();
        $expired = Carbon::parse($this->tgl_expired)->startOfDay();
        
        // Hitung selisih hari (bisa positif atau negatif)
        return $today->diffInDays($expired, false);
    }

    // Mendapatkan teks sisa hari yang user-friendly - DIPERBAIKI
    public function getSisaHariTextAttribute()
    {
        $sisa = $this->sisa_hari;
        
        if ($sisa < 0) {
            return 'Expired ' . abs($sisa) . ' hari yang lalu';
        } elseif ($sisa == 0) {
            return 'Expired hari ini';
        } elseif ($sisa <= 7) {
            return $sisa . ' hari lagi (segera expired)';
        } else {
            return $sisa . ' hari lagi';
        }
    }

    // Mendapatkan warna status untuk sisa hari - DIPERBAIKI
    public function getSisaHariClassAttribute()
    {
        $sisa = $this->sisa_hari;
        
        if ($sisa < 0) {
            return 'bg-red-100 text-red-700 border-red-200';
        } elseif ($sisa == 0) {
            return 'bg-red-100 text-red-700 border-red-200';
        } elseif ($sisa <= 7) {
            return 'bg-yellow-100 text-yellow-700 border-yellow-200';
        } else {
            return 'bg-green-100 text-green-700 border-green-200';
        }
    }

    // Format tanggal expired untuk display
    public function getTglExpiredFormattedAttribute()
    {
        return $this->tgl_expired ? $this->tgl_expired->format('d/m/Y') : '-';
    }

    // Format tanggal daftar untuk display
    public function getTglDaftarFormattedAttribute()
    {
        return $this->tgl_daftar ? $this->tgl_daftar->format('d/m/Y') : '-';
    }

    // Cek apakah member akan segera expired (≤7 hari)
    public function getIsExpiringSoonAttribute()
    {
        $sisa = $this->sisa_hari;
        return $sisa >= 0 && $sisa <= 7;
    }
}