<?php

namespace App\Exports;

use App\Models\Product;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class StockExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected $products;
    protected $filterInfo;

    public function __construct($products, $filterInfo = null)
    {
        $this->products = $products;
        $this->filterInfo = $filterInfo;
    }

    public function collection()
    {
        return $this->products;
    }

    public function title(): string
    {
        return 'Data Stok';
    }

    public function headings(): array
    {
        $cols = 7;
        $merge = array_fill(0, $cols, '');

        return [
            array_merge(['TRAXFIT GYM'], array_slice($merge, 1)),
            array_merge(['Laporan Data Stok Produk'], array_slice($merge, 1)),
            array_merge([$this->filterInfo ?? ('Diekspor pada: ' . Carbon::now()->format('d/m/Y H:i:s'))], array_slice($merge, 1)),
            $merge,
            ['NAMA PRODUK', 'KATEGORI', 'HARGA (Rp)', 'STOK', 'STATUS STOK', 'STATUS PRODUK', 'TGL DITAMBAHKAN'],
        ];
    }

    public function map($product): array
    {
        return [
            $product->nama_produk,
            $product->category->nama_kategori ?? '-',
            $product->harga,
            $product->stok,
            $this->getStockStatus($product->stok),
            $product->status ? 'Aktif' : 'Non-Aktif',
            Carbon::parse($product->created_at)->format('d/m/Y'),
        ];
    }

    private function getStockStatus($stok)
    {
        if ($stok == 0) {
            return 'Habis';
        } elseif ($stok <= 5) {
            return 'Menipis';
        } else {
            return 'Tersedia';
        }
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastCol = 'G';

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

        // Format harga sebagai angka ribuan
        $sheet->getStyle("C6:C{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');

        // Baris data - zebra striping + status coloring
        for ($row = 6; $row <= $lastRow; $row++) {
            $fillColor = ($row % 2 === 0) ? 'F9F7FD' : 'FFFFFF';
            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                'font'      => ['size' => 10, 'name' => 'Arial'],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E0E0E0']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(18);

            // Warna status stok kolom E
            $statusStokCell = "E{$row}";
            $statusStokVal  = $sheet->getCell($statusStokCell)->getValue();
            if ($statusStokVal === 'Tersedia') {
                $sheet->getStyle($statusStokCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '1A7A3C']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D4EDDA']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            } elseif ($statusStokVal === 'Menipis') {
                $sheet->getStyle($statusStokCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '7A5C00']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF3CD']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            } elseif ($statusStokVal === 'Habis') {
                $sheet->getStyle($statusStokCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'A00000']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FDDEDE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }

            // Warna status produk kolom F
            $statusProdukCell = "F{$row}";
            $statusProdukVal  = $sheet->getCell($statusProdukCell)->getValue();
            if ($statusProdukVal === 'Aktif') {
                $sheet->getStyle($statusProdukCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '1A7A3C']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D4EDDA']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            } elseif ($statusProdukVal === 'Non-Aktif') {
                $sheet->getStyle($statusProdukCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '555555']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EEEEEE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }
        }

        // Stok rata tengah
        $sheet->getStyle("D6:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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