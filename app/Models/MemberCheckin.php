<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MemberCheckin extends Model
{
    use HasFactory;

    protected $table = 'member_checkin';

    protected $fillable = [
        'id_member',
        'tanggal',
        'jam_masuk',
        'id_kasir',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'jam_masuk' => 'datetime',
    ];

    // Relasi dengan member
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    // Relasi dengan kasir (User)
    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }

    // Scope untuk check-in hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    // Cek apakah member sudah check-in hari ini
    public static function sudahCheckinHariIni($memberId)
    {
        return self::where('id_member', $memberId)
            ->whereDate('tanggal', Carbon::today())
            ->exists();
    }
}