<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GymSetting extends Model
{
    protected $table = 'gym_settings';
    
    protected $fillable = [
        'nama_gym',
        'alamat',
        'telepon',
        'email',
        'logo',
        'footer_struk',
        'harga_visit',
    ];

    protected $casts = [
        'harga_visit' => 'decimal:2',
    ];

    // Helper function untuk format harga
    public function getHargaVisitFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_visit, 0, ',', '.');
    }

    // Helper function untuk mengambil setting pertama
    public static function getSetting()
    {
        $setting = self::first();
        if (!$setting) {
            $setting = self::create([
                'nama_gym' => 'TRAXFIT GYM',
                'harga_visit' => 25000,
                'footer_struk' => 'Terima kasih telah berolahraga bersama kami!'
            ]);
        }
        return $setting;
    }

    // Helper untuk logo URL
    public function getLogoUrlAttribute()
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }
}