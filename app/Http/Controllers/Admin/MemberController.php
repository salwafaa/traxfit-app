<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipPackage;
use App\Models\Log;
use App\Models\Transaction;
use App\Models\MemberCheckin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('package')->latest()->get();
        
        $activeMembers = Member::where('status', 'active')
            ->whereDate('tgl_expired', '>=', now()->toDateString())
            ->count();
            
        $expiredMembers = Member::where('status', 'expired')
            ->orWhereDate('tgl_expired', '<', now()->toDateString())
            ->count();
            
        $expiringSoon = Member::where('status', 'active')
            ->whereDate('tgl_expired', '>=', now()->toDateString())
            ->whereRaw('DATEDIFF(tgl_expired, CURDATE()) <= 7')
            ->whereRaw('DATEDIFF(tgl_expired, CURDATE()) >= 0')
            ->count();
        
        return view('admin.members.index', compact('members', 'activeMembers', 'expiredMembers', 'expiringSoon'));
    }

    public function create()
    {
        abort(403, 'Admin tidak diizinkan mendaftarkan member baru. Silakan hubungi kasir.');
    }

    public function store(Request $request)
    {
        abort(403, 'Admin tidak diizinkan mendaftarkan member baru. Silakan hubungi kasir.');
    }

    public function show($id)
    {
        $member = Member::with(['package', 'transactions' => function($query) {
            $query->latest()->limit(20);
        }, 'creator'])->findOrFail($id);
        
        return view('admin.members.show', compact('member'));
    }

    public function edit($id)
    {
        $member = Member::with('package')->findOrFail($id);
        $packages = MembershipPackage::where('status', true)->get();
        return view('admin.members.edit', compact('member', 'packages'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'jenis_identitas' => 'nullable|string|in:KTP,Passport,SIM,Other',
            'no_identitas' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'id_paket' => 'required|exists:membership_packages,id',
            'tgl_expired' => 'required|date',
            'status' => 'required|in:active,expired',
            'foto_identitas' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $oldData = [
                'nama' => $member->nama,
                'telepon' => $member->telepon,
                'paket' => $member->package->nama_paket ?? '-',
                'tgl_expired' => $member->tgl_expired_formatted,
                'status' => $member->status
            ];

            $tglExpired = Carbon::parse($request->tgl_expired);
            $today = now()->startOfDay();
            
            $status = $request->status;
            if ($tglExpired->startOfDay() < $today) {
                $status = 'expired';
            }

            $data = [
                'nama' => $request->nama,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'jenis_identitas' => $request->jenis_identitas,
                'no_identitas' => $request->no_identitas,
                'tgl_lahir' => $request->tgl_lahir,
                'id_paket' => $request->id_paket,
                'tgl_expired' => $request->tgl_expired,
                'status' => $status,
            ];

            if ($request->hasFile('foto_identitas')) {
                if ($member->foto_identitas && Storage::disk('public')->exists($member->foto_identitas)) {
                    Storage::disk('public')->delete($member->foto_identitas);
                }
                
                $file = $request->file('foto_identitas');
                $filename = 'identitas_' . $member->kode_member . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('identitas', $filename, 'public');
                $data['foto_identitas'] = $path;
            }

            $member->update($data);

            $changes = [];
            if ($oldData['nama'] != $request->nama) $changes[] = 'nama';
            if ($oldData['telepon'] != $request->telepon) $changes[] = 'telepon';
            if ($oldData['tgl_expired'] != $tglExpired->format('d/m/Y')) $changes[] = 'tanggal expired';
            if ($oldData['status'] != $status) $changes[] = 'status';
            if ($member->id_paket != $request->id_paket) $changes[] = 'paket';

            $keterangan = 'Admin mengupdate data member: ' . $member->nama . ' (' . $member->kode_member . ')';
            if (!empty($changes)) {
                $keterangan .= '. Perubahan pada: ' . implode(', ', $changes);
            }

            Log::create([
                'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                'activity' => 'Update Member',
                'keterangan' => $keterangan,
            ]);

            DB::commit();

            return redirect()->route('admin.members.index')
                ->with('success', 'Data member ' . $member->nama . ' berhasil diupdate.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        DB::beginTransaction();
        try {
            $namaMember = $member->nama;
            $kodeMember = $member->kode_member;
            
            $hasTransactions = $member->transactions()->count() > 0;
            $hasCheckins = $member->checkins()->count() > 0;
            
            if ($hasTransactions || $hasCheckins) {
                $member->delete();
                
                $keterangan = 'Admin menghapus member (soft delete): ' . $namaMember . ' (' . $kodeMember . ')';
                
                if ($hasTransactions) {
                    $keterangan .= '. Member memiliki ' . $member->transactions()->count() . ' transaksi.';
                }
                if ($hasCheckins) {
                    $keterangan .= ' Member memiliki ' . $member->checkins()->count() . ' history checkin.';
                }
                
                Log::create([
                   'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Delete Member (Soft)',
                    'keterangan' => $keterangan,
                ]);
                
                DB::commit();
                
                return redirect()->route('admin.members.index')
                    ->with('success', 'Member ' . $namaMember . ' berhasil dinonaktifkan (soft delete). Data transaksi tetap tersimpan.');
            } else {
                if ($member->foto_identitas && Storage::disk('public')->exists($member->foto_identitas)) {
                    Storage::disk('public')->delete($member->foto_identitas);
                }
                
                $member->forceDelete();
                
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Delete Member (Permanent)',
                    'keterangan' => 'Admin menghapus permanen member: ' . $namaMember . ' (' . $kodeMember . ')',
                ]);
                
                DB::commit();
                
                return redirect()->route('admin.members.index')
                    ->with('success', 'Member ' . $namaMember . ' berhasil dihapus permanen.');
            }
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.members.index')
                ->with('error', 'Terjadi kesalahan saat menghapus member: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $member = Member::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $oldStatus = $member->status;
            $newStatus = ($oldStatus == 'active') ? 'expired' : 'active';
            
            if ($newStatus == 'active') {
                $today = now()->startOfDay();
                $expired = $member->tgl_expired ? Carbon::parse($member->tgl_expired)->startOfDay() : null;
                
                if (!$expired || $expired < $today) {
                    return redirect()->back()
                        ->with('error', 'Tidak dapat mengaktifkan member karena tanggal expired sudah lewat. Perbaiki tanggal expired terlebih dahulu.');
                }
            }
            
            $member->update([
                'status' => $newStatus,
            ]);

            Log::create([
               'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                'activity' => 'Toggle Member Status',
                'keterangan' => 'Admin mengubah status member ' . $member->nama . ' (' . $member->kode_member . ') dari ' . $oldStatus . ' menjadi ' . $newStatus,
            ]);

            DB::commit();

            $statusText = ($newStatus == 'active') ? 'aktif' : 'expired';
            return redirect()->route('admin.members.index')
                ->with('success', 'Status member ' . $member->nama . ' berhasil diubah menjadi ' . $statusText . '.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.members.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function fixExpiredDate(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'tgl_expired' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $oldDate = $member->tgl_expired_formatted;
            $newDate = Carbon::parse($request->tgl_expired)->format('d/m/Y');
            
            $tglExpired = Carbon::parse($request->tgl_expired);
            $today = now()->startOfDay();
            
            $member->update([
                'tgl_expired' => $request->tgl_expired,
            ]);

            if ($tglExpired->startOfDay() < $today) {
                $member->update(['status' => 'expired']);
            } else {
                $member->update(['status' => 'active']);
            }

            Log::create([
                'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                'activity' => 'Fix Expired Date',
                'keterangan' => 'Admin memperbaiki tanggal expired member ' . $member->nama . ' (' . $member->kode_member . ') dari ' . $oldDate . ' menjadi ' . $newDate,
            ]);

            DB::commit();

            return redirect()->route('admin.members.index')
                ->with('success', 'Tanggal expired member ' . $member->nama . ' berhasil diperbaiki.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}