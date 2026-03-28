<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCheckin extends Model
{
    use HasFactory;

    // Tentukan nama tabel (karena tidak mengikuti konvensi plural)
    protected $table = 'member_checkin';
    
    protected $fillable = [
        'id_member',
        'tanggal',
        'jam_masuk',
        'id_kasir'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
    ];

    // Relasi dengan member
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    // Relasi dengan kasir
    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }
}