<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class StockLogExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected $logs;
    protected $filterInfo;

    public function __construct($logs, $filterInfo = null)
    {
        $this->logs = $logs;
        $this->filterInfo = $filterInfo;
    }

    public function collection()
    {
        return $this->logs;
    }

    public function title(): string
    {
        return 'Log Stok';
    }

    public function headings(): array
    {
        $cols = 10;
        $merge = array_fill(0, $cols, '');

        return [
            array_merge(['TRAXFIT GYM'], array_slice($merge, 1)),
            array_merge(['Laporan Log Stok Produk'], array_slice($merge, 1)),
            array_merge([$this->filterInfo ?? ('Diekspor pada: ' . Carbon::now()->format('d/m/Y H:i:s'))], array_slice($merge, 1)),
            $merge,
            ['NO', 'TANGGAL', 'JAM', 'PRODUK', 'KATEGORI', 'TIPE', 'JUMLAH', 'KETERANGAN', 'USER', 'ROLE USER'],
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
            $log->user->role ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastCol = 'J';

        // Baris 1 - Nama Gym
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 18, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '27124A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(35);

        // Baris 2 - Sub judul
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3D1E6E']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(25);

        // Baris 3 - Info filter
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->getStyle('A3')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '555555'], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F0FA']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(18);

        // Baris 4 - Spacer
        $sheet->mergeCells("A4:{$lastCol}4");
        $sheet->getStyle("A4:{$lastCol}4")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
        ]);
        $sheet->getRowDimension(4)->setRowHeight(6);

        // Baris 5 - Header kolom
        $sheet->getStyle("A5:{$lastCol}5")->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '27124A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
        ]);
        $sheet->getRowDimension(5)->setRowHeight(22);

        // Baris data - zebra striping + warna tipe masuk/keluar
        for ($row = 6; $row <= $lastRow; $row++) {
            $fillColor = ($row % 2 === 0) ? 'F9F7FD' : 'FFFFFF';
            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                'font'      => ['size' => 10, 'name' => 'Arial'],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E0E0E0']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(18);

            // Warna tipe kolom F
            $tipeCell = "F{$row}";
            $tipeVal  = $sheet->getCell($tipeCell)->getValue();
            if (strtolower($tipeVal) === 'masuk') {
                $sheet->getStyle($tipeCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '1A7A3C']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D4EDDA']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            } elseif (strtolower($tipeVal) === 'keluar') {
                $sheet->getStyle($tipeCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'A00000']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FDDEDE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }

            // Warna jumlah kolom G
            $jumlahCell = "G{$row}";
            $jumlahVal  = $sheet->getCell($jumlahCell)->getValue();
            if (str_starts_with((string) $jumlahVal, '+')) {
                $sheet->getStyle($jumlahCell)->getFont()->getColor()->setRGB('1A7A3C');
                $sheet->getStyle($jumlahCell)->getFont()->setBold(true);
            } elseif (str_starts_with((string) $jumlahVal, '-')) {
                $sheet->getStyle($jumlahCell)->getFont()->getColor()->setRGB('A00000');
                $sheet->getStyle($jumlahCell)->getFont()->setBold(true);
            }
            $sheet->getStyle($jumlahCell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // NO rata tengah
        $sheet->getStyle("A6:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->freezePane('A6');
            },
        ];
    }
}