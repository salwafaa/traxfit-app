<?php

namespace App\Exports;

use App\Models\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ActivityExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    public function collection()
    {
        return $this->logs;
    }

    public function headings(): array
    {
        return [
            'WAKTU',
            'TANGGAL',
            'JAM',
            'USER',
            'ROLE',
            'AKTIVITAS',
            'KETERANGAN',
        ];
    }

    public function map($log): array
    {
        return [
            Carbon::parse($log->created_at)->format('d/m/Y H:i:s'),
            Carbon::parse($log->created_at)->format('d/m/Y'),
            Carbon::parse($log->created_at)->format('H:i:s'),
            $log->user->nama ?? 'Unknown',
            $this->getRoleName($log->role_user),
            $log->activity,
            $log->keterangan,
        ];
    }

    private function getRoleName($role)
    {
        $roleMap = [
            'admin' => 'Admin',
            'kasir' => 'Kasir',
            'owner' => 'Owner',
        ];
        
        return $roleMap[$role] ?? '-';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}