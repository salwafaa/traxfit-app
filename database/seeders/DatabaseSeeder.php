<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GymSetting;
use App\Models\ProductCategory;
use App\Models\MembershipPackage;
use App\Models\Product;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\MemberCheckin;
use App\Models\StokLog;
use App\Models\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat data gym settings
        GymSetting::create([
            'nama_gym' => 'TraxFit Gym',
            'alamat' => 'Jl. Contoh No. 123, Kota Bandung',
            'telepon' => '0812-3456-7890',
            'footer_struk' => 'Terima kasih telah berbelanja di TraxFit Gym',
        ]);

        // Buat user admin, kasir, dan owner
        $admin = User::create([
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'nama' => 'Administrator',
            'role' => 'admin',
            'status' => true,
        ]);

        $kasir = User::create([
            'username' => 'kasir',
            'password' => Hash::make('password123'),
            'nama' => 'Kasir Utama',
            'role' => 'kasir',
            'status' => true,
        ]);

        $owner = User::create([
            'username' => 'owner',
            'password' => Hash::make('password123'),
            'nama' => 'Pemilik Gym',
            'role' => 'owner',
            'status' => true,
        ]);
    }
}