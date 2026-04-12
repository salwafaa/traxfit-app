<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class StockExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        return [
            'NAMA PRODUK',
            'KATEGORI',
            'HARGA (Rp)',
            'STOK',
            'STATUS STOK',
            'STATUS PRODUK',
            'TGL DITAMBAHKAN'
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
            Carbon::parse($product->created_at)->format('d/m/Y')
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
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}