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
        'via_transaksi',
    ];

    protected $casts = [
        'tanggal'       => 'date',
        'jam_masuk'     => 'datetime',
        'via_transaksi' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    public static function sudahCheckinHariIni(int $memberId): bool
    {
        $today = Carbon::today();

        $adaCheckin = self::where('id_member', $memberId)
            ->whereDate('tanggal', $today)
            ->exists();

        if ($adaCheckin) {
            return true;
        }

        $adaTransaksiHariIni = Member::where('id', $memberId)
            ->where('status', 'active')
            ->where(function ($q) use ($today) {
                $q->whereDate('tgl_daftar', $today)
                  ->orWhereDate('updated_at', $today);
            })
            ->exists();

        return $adaTransaksiHariIni;
    }

    public static function buatCheckinOtomatis(int $memberId, ?int $kasirId = null): ?self
    {
        $today = Carbon::today();

        $sudahAda = self::where('id_member', $memberId)
            ->whereDate('tanggal', $today)
            ->exists();

        if ($sudahAda) {
            return null;
        }

        return self::create([
            'id_member'     => $memberId,
            'tanggal'       => $today->toDateString(),
            'jam_masuk'     => Carbon::now(),
            'id_kasir'      => $kasirId,
            'via_transaksi' => true,
        ]);
    }
}