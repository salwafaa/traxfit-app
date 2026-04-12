<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'members';

    protected $fillable = [
        'kode_member',
        'nama',
        'telepon',
        'alamat',
        'id_paket',
        'no_identitas',
        'jenis_identitas',
        'tgl_lahir',
        'foto_identitas',
        'tgl_daftar',
        'tgl_expired',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tgl_daftar'  => 'date',
        'tgl_expired' => 'date',
        'tgl_lahir'   => 'date',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate kode_member unik saat pertama kali dibuat
        static::creating(function ($member) {
            $year  = date('Y');
            $month = date('m');

            $lastMember = Member::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastMember && $lastMember->kode_member) {
                $lastNumber = intval(substr($lastMember->kode_member, -4));
                $newNumber  = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $member->kode_member = 'MBR-' . $year . $month . '-' . $newNumber;

            if (!$member->tgl_daftar) {
                $member->tgl_daftar = now();
            }
        });

        /**
         * FIX: Auto-update status expired hanya jika status belum di-set ke 'active'
         * secara eksplisit pada operasi yang sama (contoh: perpanjangan).
         * Cek isDirty('status') agar tidak override nilai baru yang dikirim controller.
         */
        static::saving(function ($member) {
            // Jika controller sedang mengubah status ke 'active', jangan di-override
            if ($member->isDirty('status') && $member->status === 'active') {
                return;
            }

            if ($member->tgl_expired) {
                $today   = now()->startOfDay();
                $expired = Carbon::parse($member->tgl_expired)->startOfDay();

                if ($expired < $today) {
                    $member->status = 'expired';
                }
            }
        });
    }

    // ─── Relasi ──────────────────────────────────────────────────────────────

    public function package()
    {
        return $this->belongsTo(MembershipPackage::class, 'id_paket');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_member');
    }

    public function checkins()
    {
        return $this->hasMany(MemberCheckin::class, 'id_member');
    }

    // ─── Accessor ────────────────────────────────────────────────────────────

    public function getFotoIdentitasUrlAttribute()
    {
        if ($this->foto_identitas && Storage::disk('public')->exists($this->foto_identitas)) {
            return Storage::url($this->foto_identitas);
        }
        return null;
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->whereDate('tgl_expired', '>=', now()->toDateString());
    }

    /**
     * FIX: Scope expired dibungkus where() agar tidak bocor ke query lain
     * akibat orWhereDate tanpa grup.
     */
    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'expired')
              ->orWhereDate('tgl_expired', '<', now()->toDateString());
        });
    }

    // ─── Computed Attributes ─────────────────────────────────────────────────

    /**
     * Cek apakah member aktif (status active DAN belum expired)
     */
    public function getIsActiveAttribute()
    {
        if (!$this->tgl_expired) {
            return false;
        }

        $today   = now()->startOfDay();
        $expired = Carbon::parse($this->tgl_expired)->startOfDay();

        return $this->status === 'active' && $expired >= $today;
    }

    /**
     * Sisa hari: positif = belum expired, negatif = sudah expired
     */
    public function getSisaHariAttribute()
    {
        if (!$this->tgl_expired) {
            return 0;
        }

        $today   = now()->startOfDay();
        $expired = Carbon::parse($this->tgl_expired)->startOfDay();

        return $today->diffInDays($expired, false);
    }

    public function getSisaHariTextAttribute()
    {
        $sisa = $this->sisa_hari;

        if ($sisa < 0) {
            return 'Expired ' . abs($sisa) . ' hari yang lalu';
        } elseif ($sisa === 0) {
            return 'Expired hari ini';
        } elseif ($sisa <= 7) {
            return $sisa . ' hari lagi (segera expired)';
        } else {
            return $sisa . ' hari lagi';
        }
    }

    public function getSisaHariClassAttribute()
    {
        $sisa = $this->sisa_hari;

        if ($sisa <= 0) {
            return 'bg-red-100 text-red-700 border-red-200';
        } elseif ($sisa <= 7) {
            return 'bg-yellow-100 text-yellow-700 border-yellow-200';
        } else {
            return 'bg-green-100 text-green-700 border-green-200';
        }
    }

    public function getTglExpiredFormattedAttribute()
    {
        return $this->tgl_expired ? $this->tgl_expired->format('d/m/Y') : '-';
    }

    public function getTglDaftarFormattedAttribute()
    {
        return $this->tgl_daftar ? $this->tgl_daftar->format('d/m/Y') : '-';
    }

    public function getTglLahirFormattedAttribute()
    {
        return $this->tgl_lahir ? $this->tgl_lahir->format('d/m/Y') : '-';
    }

    public function getIsExpiringSoonAttribute()
    {
        $sisa = $this->sisa_hari;
        return $sisa >= 0 && $sisa <= 7;
    }
}