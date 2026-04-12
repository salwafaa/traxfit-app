<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class MemberExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $members;
    
    public function __construct($members)
    {
        $this->members = $members;
    }
    
    public function collection()
    {
        return $this->members;
    }
    
    public function headings(): array
    {
        return [
            'NO',
            'NAMA MEMBER',
            'NOMOR TELEPON',
            'EMAIL',
            'ALAMAT',
            'PAKET',
            'TANGGAL DAFTAR',
            'TANGGAL EXPIRED',
            'SISA HARI',
            'JUMLAH CHECK-IN',
            'STATUS',
            'TERDAFTAR OLEH'
        ];
    }
    
    public function map($member): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        // Hitung sisa hari
        $sisaHari = 0;
        if ($member->tgl_expired) {
            $sisaHari = Carbon::now()->diffInDays(Carbon::parse($member->tgl_expired), false);
            $sisaHari = $sisaHari < 0 ? 0 : $sisaHari;
        }
        
        // Status text
        $statusText = '';
        $statusClass = '';
        if ($member->status == 'active' && $sisaHari > 0) {
            $statusText = 'Aktif';
        } elseif ($member->status == 'pending') {
            $statusText = 'Pending';
        } else {
            $statusText = 'Expired';
        }
        
        return [
            $rowNumber,
            $member->nama,
            $member->telepon ?? '-',
            $member->email ?? '-',
            $member->alamat ?? '-',
            $member->package ? $member->package->nama_paket : '-',
            $member->tgl_daftar ? Carbon::parse($member->tgl_daftar)->format('d/m/Y') : '-',
            $member->tgl_expired ? Carbon::parse($member->tgl_expired)->format('d/m/Y') : '-',
            $sisaHari > 0 ? $sisaHari . ' hari' : ($sisaHari == 0 && $member->tgl_expired ? 'Hari ini' : 'Expired'),
            $member->checkins_count ?? 0,
            $statusText,
            $member->user ? $member->user->nama : '-'
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '27124A']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF']]
            ],
        ];
    }
}