<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';  

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'role_user',
        'activity',
        'keterangan',
    ];

    /**
     * Relationship dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}