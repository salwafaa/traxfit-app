<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'nama',
        'role',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => 'boolean',
        'last_login' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKasir()
    {
        return $this->role === 'kasir';
    }

    public function isOwner()
    {
        return $this->role === 'owner';
    }

    /**
     * Accessor untuk format last_login sederhana
     */
    public function getSimpleLastLoginAttribute()
    {
        if (!$this->last_login) {
            return null;
        }
        
        // Format yang simple: tanggal dan jam saja
        return [
            'date' => $this->last_login->format('d/m/Y'),
            'time' => $this->last_login->format('H:i')
        ];
    }

     public function logs()
    {
        return $this->hasMany(Log::class, 'id_user');
    }
}