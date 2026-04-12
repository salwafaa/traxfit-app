<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'NO. INVOICE',
            'TANGGAL',
            'JAM',
            'KASIR',
            'MEMBER',
            'TOTAL HARGA (Rp)',
            'METODE BAYAR',
            'JUMLAH BAYAR (Rp)',
            'KEMBALIAN (Rp)',
            'JENIS TRANSAKSI',
            'DETAIL TAMBAHAN',
            'STATUS'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->nomor_unik,
            Carbon::parse($transaction->created_at)->format('d/m/Y'),
            Carbon::parse($transaction->created_at)->format('H:i:s'),
            $transaction->user->nama ?? '-',
            $transaction->member->nama ?? 'Non-Member',
            $transaction->total_harga,
            $transaction->metode_bayar == 'cash' ? 'Tunai' : 'QRIS',
            $transaction->uang_bayar ?? 0,
            $transaction->uang_kembali ?? 0,
            $this->getJenisTransaksi($transaction->jenis_transaksi),
            $this->getDetailTambahan($transaction),
            $transaction->status_transaksi ?? 'Selesai'
        ];
    }

    private function getJenisTransaksi($jenis)
    {
        $jenisMap = [
            'produk' => 'Produk',
            'visit' => 'Visit',
            'membership' => 'Membership',
            'produk_visit' => 'Produk + Visit',
            'produk_membership' => 'Produk + Membership',
        ];
        
        return $jenisMap[$jenis] ?? '-';
    }

    private function getDetailTambahan($transaction)
    {
        if (empty($transaction->data_tambahan)) {
            return '-';
        }

        $details = [];
        
        if ($transaction->isVisitOnly() || $transaction->isProdukDanVisit()) {
            $details[] = 'Visit: Rp ' . number_format($transaction->data_tambahan['harga_visit'] ?? 0, 0, ',', '.');
            if (isset($transaction->data_tambahan['tgl_visit'])) {
                $details[] = 'Tgl: ' . Carbon::parse($transaction->data_tambahan['tgl_visit'])->format('d/m/Y');
            }
        }
        
        if ($transaction->isMembershipOnly() || $transaction->isProdukDanMembership()) {
            $details[] = 'Paket: ' . ($transaction->data_tambahan['nama_paket'] ?? '-');
            $details[] = 'Harga: Rp ' . number_format($transaction->data_tambahan['harga_paket'] ?? 0, 0, ',', '.');
            if (isset($transaction->data_tambahan['tgl_mulai'])) {
                $details[] = 'Mulai: ' . Carbon::parse($transaction->data_tambahan['tgl_mulai'])->format('d/m/Y');
            }
            if (isset($transaction->data_tambahan['tgl_selesai'])) {
                $details[] = 'Selesai: ' . Carbon::parse($transaction->data_tambahan['tgl_selesai'])->format('d/m/Y');
            }
        }
        
        return empty($details) ? '-' : implode(' | ', $details);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}