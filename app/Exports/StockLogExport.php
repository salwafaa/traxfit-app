<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockLogExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
            'No',
            'Tanggal',
            'Jam',
            'Produk',
            'Kategori',
            'Tipe',
            'Jumlah',
            'Keterangan',
            'User',
            'Role User'
        ];
    }
    
    public function map($log): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        return [
            $rowNumber,
            $log->created_at->format('d/m/Y'),
            $log->created_at->format('H:i:s'),
            $log->product->nama_produk ?? '-',
            $log->product->category->nama_kategori ?? '-',
            ucfirst($log->tipe),
            $log->tipe == 'masuk' ? '+' . $log->qty : '-' . $log->qty,
            $log->keterangan,
            $log->user->nama ?? '-',
            $log->user->role ?? '-'
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:J1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 
                    'startColor' => ['rgb' => '27124A']
                ], 
                'font' => ['color' => ['rgb' => 'FFFFFF']]
            ],
        ];
    }
}