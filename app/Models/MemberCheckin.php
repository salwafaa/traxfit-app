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
        'via_transaksi', // kolom baru: flag apakah check-in ini otomatis dari transaksi
    ];

    protected $casts = [
        'tanggal'       => 'date',
        'jam_masuk'     => 'datetime',
        'via_transaksi' => 'boolean',
    ];

    // ─── Relasi ──────────────────────────────────────────────────────────────

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    // ─── Static Helpers ──────────────────────────────────────────────────────

    /**
     * Cek apakah member sudah check-in hari ini.
     * Dianggap sudah check-in jika:
     *   1. Ada record check-in manual hari ini, ATAU
     *   2. Ada transaksi membership (perpanjang / daftar baru) yang dibuat hari ini
     *
     * @param  int  $memberId
     * @return bool
     */
    public static function sudahCheckinHariIni(int $memberId): bool
    {
        $today = Carbon::today();

        // 1. Cek record check-in biasa
        $adaCheckin = self::where('id_member', $memberId)
            ->whereDate('tanggal', $today)
            ->exists();

        if ($adaCheckin) {
            return true;
        }

        // 2. Cek apakah ada transaksi membership hari ini
        //    (tgl_daftar = hari ini → member baru ATAU updated_at = hari ini dengan status active
        //     → perpanjangan hari ini)
        //    Kita cek lewat kolom updated_at pada tabel members karena perpanjang()
        //    memanggil update() yang menyentuh updated_at.
        $adaTransaksiHariIni = Member::where('id', $memberId)
            ->where('status', 'active')
            ->where(function ($q) use ($today) {
                // Daftar baru hari ini
                $q->whereDate('tgl_daftar', $today)
                  // ATAU diperpanjang hari ini (updated_at diperbarui saat perpanjang)
                  ->orWhereDate('updated_at', $today);
            })
            ->exists();

        return $adaTransaksiHariIni;
    }

    /**
     * Buat record check-in otomatis akibat transaksi (daftar baru / perpanjang).
     * Tidak akan membuat duplikat jika sudah ada check-in hari ini.
     *
     * @param  int       $memberId
     * @param  int|null  $kasirId
     * @return self|null  Instance baru jika berhasil dibuat, null jika sudah ada
     */
    public static function buatCheckinOtomatis(int $memberId, ?int $kasirId = null): ?self
    {
        $today = Carbon::today();

        // Jangan buat duplikat
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