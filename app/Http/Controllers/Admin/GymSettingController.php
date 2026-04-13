<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GymSetting;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Auth;


class GymSettingController extends Controller
{
    public function index()
    {
        $setting = GymSetting::first();
        
        if (!$setting) {
            $setting = GymSetting::create([
                'nama_gym' => 'TRAXFIT GYM',
                'harga_visit' => 25000,
                'footer_struk' => 'Terima kasih telah berolahraga bersama kami!'
            ]);
        }
        
        try {
            Log::create([
                'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                'activity' => 'View Gym Settings',
                'keterangan' => 'Admin melihat pengaturan gym',
            ]);
        } catch (\Exception $e) {
            FacadesLog::error('Gagal menyimpan log: ' . $e->getMessage());
        }
        
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        FacadesLog::info('Data settings update:', $request->all());
        
        $request->validate([
            'nama_gym' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'footer_struk' => 'nullable|string|max:255',
            'harga_visit' => 'required|numeric|min:0|max:10000000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $setting = GymSetting::first();
            
            if (!$setting) {
                $setting = new GymSetting();
            }

            $data = [
                'nama_gym' => $request->nama_gym,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'footer_struk' => $request->footer_struk,
                'harga_visit' => $request->harga_visit,
            ];

            if ($request->hasFile('logo')) {
                if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                    Storage::disk('public')->delete($setting->logo);
                }
                
                $path = $request->file('logo')->store('gym-settings', 'public');
                $data['logo'] = $path;
            }

            $setting->fill($data);
            $setting->save();
            
            FacadesLog::info('Settings saved:', $setting->toArray());

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Update Gym Settings',
                    'keterangan' => 'Admin mengupdate pengaturan gym (harga visit: Rp ' . number_format($request->harga_visit, 0, ',', '.') . ', nama gym: ' . $request->nama_gym . ')',
                ]);
            } catch (\Exception $e) {
                FacadesLog::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.settings.index')
                ->with('success', 'Pengaturan gym berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            FacadesLog::error('Error update settings: ' . $e->getMessage());
            
            return redirect()->route('admin.settings.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}