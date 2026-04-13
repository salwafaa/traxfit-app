<?php

namespace App\Exports;

use App\Models\Transaction;
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

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected $transactions;
    protected $filterInfo;

    public function __construct($transactions, $filterInfo = null)
    {
        $this->transactions = $transactions;
        $this->filterInfo = $filterInfo;
    }

    public function collection()
    {
        // Pastikan relasi details.product sudah di-load agar getDetailTambahan bisa tampilkan produk
        if ($this->transactions instanceof \Illuminate\Database\Eloquent\Collection) {
            $this->transactions->loadMissing(['details.product', 'user', 'member']);
        }

        return $this->transactions;
    }

    public function title(): string
    {
        return 'Data Transaksi';
    }

    public function headings(): array
    {
        $cols = 12;
        $merge = array_fill(0, $cols, '');

        return [
            array_merge(['TRAXFIT GYM'], array_slice($merge, 1)),
            array_merge(['Laporan Data Transaksi'], array_slice($merge, 1)),
            array_merge([$this->filterInfo ?? ('Diekspor pada: ' . Carbon::now()->format('d/m/Y H:i:s'))], array_slice($merge, 1)),
            $merge,
            [
                'NO. TRANSAKSI', 'TANGGAL', 'JAM', 'KASIR',
                'MEMBER', 'TOTAL HARGA (Rp)', 'METODE BAYAR',
                'JUMLAH BAYAR (Rp)', 'KEMBALIAN (Rp)',
                'JENIS TRANSAKSI', 'DETAIL TAMBAHAN', 'STATUS',
            ],
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
            $transaction->status_transaksi ?? 'Selesai',
        ];
    }

    private function getJenisTransaksi($jenis)
    {
        $jenisMap = [
            'produk'              => 'Produk',
            'visit'               => 'Visit',
            'membership'          => 'Membership',
            'produk_visit'        => 'Produk + Visit',
            'produk_membership'   => 'Produk + Membership',
        ];

        return $jenisMap[$jenis] ?? '-';
    }

    /**
     * Ambil data_tambahan sebagai array, terlepas dari apakah sudah di-cast atau belum.
     * Handles: array (sudah di-cast Eloquent), string JSON, atau null.
     */
    private function resolveDataTambahan($transaction): array
    {
        $raw = $transaction->getRawOriginal('data_tambahan') ?? $transaction->data_tambahan;

        if (is_array($raw)) {
            return $raw;
        }

        if (is_string($raw) && !empty($raw)) {
            $decoded = json_decode($raw, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    private function getDetailTambahan($transaction): string
    {
        $data = $this->resolveDataTambahan($transaction);

        if (empty($data)) {
            // Untuk transaksi produk saja, tampilkan ringkasan produk dari details
            if (in_array($transaction->jenis_transaksi, ['produk']) && $transaction->details->isNotEmpty()) {
                $produkList = $transaction->details->map(function ($d) {
                    return ($d->product->nama_produk ?? 'Produk') . ' x' . $d->qty;
                })->implode(', ');
                return 'Produk: ' . $produkList;
            }
            return '-';
        }

        $details = [];
        $jenis   = $transaction->jenis_transaksi;

        // ── VISIT ────────────────────────────────────────────────────
        if (in_array($jenis, ['visit', 'produk_visit'])) {
            $harga = $data['harga_visit'] ?? 0;
            $details[] = 'Visit: Rp ' . number_format((float) $harga, 0, ',', '.');

            if (!empty($data['tgl_visit'])) {
                $details[] = 'Tgl: ' . Carbon::parse($data['tgl_visit'])->format('d/m/Y');
            }
        }

        // ── MEMBERSHIP ───────────────────────────────────────────────
        // Mendukung DUA format data_tambahan:
        // Format A (TransactionController)      : data_tambahan['nama_paket'], data_tambahan['harga_paket']
        // Format B (MembershipTransactionCtrl)  : data_tambahan['paket_membership']['nama'], ['harga']
        if (in_array($jenis, ['membership', 'produk_membership'])) {

            // Normalise: coba Format B dulu, fallback ke Format A
            $paketNested = $data['paket_membership'] ?? null;

            $namaPaket  = $paketNested['nama']        ?? $data['nama_paket']  ?? null;
            $hargaPaket = $paketNested['harga']        ?? $data['harga_paket'] ?? null;
            $durasiHari = $paketNested['durasi_hari']  ?? $data['durasi_hari'] ?? 0;
            $idPaket    = $paketNested['id_paket']     ?? $data['id_paket']    ?? null;
            $tglMulai   = $data['tgl_mulai']   ?? null;
            $tglSelesai = $data['tgl_selesai'] ?? null;

            // Nama paket
            if (!empty($namaPaket)) {
                $details[] = 'Paket: ' . $namaPaket;
            } elseif (!empty($idPaket)) {
                $details[] = 'Paket ID: ' . $idPaket;
            }

            // Harga paket
            if ($hargaPaket !== null) {
                $details[] = 'Harga: Rp ' . number_format((float) $hargaPaket, 0, ',', '.');
            }

            // Durasi
            if ((int) $durasiHari > 0) {
                $details[] = 'Durasi: ' . $durasiHari . ' hari';
            }

            // Tanggal mulai & selesai
            if (!empty($tglMulai)) {
                $details[] = 'Mulai: ' . Carbon::parse($tglMulai)->format('d/m/Y');
            }
            if (!empty($tglSelesai)) {
                $details[] = 'Selesai: ' . Carbon::parse($tglSelesai)->format('d/m/Y');
            }

            // Flag renewal (hanya dari MembershipTransactionController)
            if (!empty($data['is_renewal'])) {
                $details[] = 'Perpanjangan: Ya';
            }
        }

        // ── PRODUK (untuk jenis produk_visit / produk_membership) ────
        // Tampilkan ringkasan produk dari relasi details jika ada
        if (in_array($jenis, ['produk_visit', 'produk_membership']) && $transaction->details->isNotEmpty()) {
            $produkList = $transaction->details->map(function ($d) {
                return ($d->product->nama_produk ?? 'Produk') . ' x' . $d->qty;
            })->implode(', ');
            $details[] = 'Produk: ' . $produkList;
        }

        return empty($details) ? '-' : implode(' | ', $details);
    }

    public function styles(Worksheet $sheet)
    {
        $lastDataRow = $sheet->getHighestRow();
        $lastCol     = 'L';

        // ── HEADER SECTION ───────────────────────────────────────────

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

        // ── DATA ROWS ────────────────────────────────────────────────

        // Format kolom harga sebagai angka ribuan
        $sheet->getStyle("F6:I{$lastDataRow}")->getNumberFormat()->setFormatCode('#,##0');

        for ($row = 6; $row <= $lastDataRow; $row++) {
            $fillColor = ($row % 2 === 0) ? 'F9F7FD' : 'FFFFFF';
            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                'font'      => ['size' => 10, 'name' => 'Arial'],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E0E0E0']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(18);

            // Warna metode bayar kolom G
            $metodeCell = "G{$row}";
            $metodeVal  = $sheet->getCell($metodeCell)->getValue();
            if ($metodeVal === 'Tunai') {
                $sheet->getStyle($metodeCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '1A5276']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D6EAF8']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            } elseif ($metodeVal === 'QRIS') {
                $sheet->getStyle($metodeCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '1A7A3C']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D4EDDA']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }

            // Warna status kolom L
            $statusCell = "L{$row}";
            $statusVal  = $sheet->getCell($statusCell)->getValue();
            if ($statusVal === 'Selesai') {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '1A7A3C']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D4EDDA']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            } elseif (in_array($statusVal, ['Dibatalkan', 'Batal'])) {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'A00000']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FDDEDE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }
        }

        // ── BARIS TOTAL PENDAPATAN ───────────────────────────────────

        $totalRow = $lastDataRow + 1;

        // Spacer sebelum total
        $sheet->mergeCells("A{$totalRow}:{$lastCol}{$totalRow}");
        $sheet->getStyle("A{$totalRow}:{$lastCol}{$totalRow}")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
        ]);
        $sheet->getRowDimension($totalRow)->setRowHeight(8);

        $totalRow++;

        // Label "TOTAL PENDAPATAN"
        $sheet->mergeCells("A{$totalRow}:E{$totalRow}");
        $sheet->getStyle("A{$totalRow}:E{$totalRow}")->applyFromArray([
            'font'      => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '27124A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getCell("A{$totalRow}")->setValue('TOTAL PENDAPATAN');
        $sheet->getRowDimension($totalRow)->setRowHeight(26);

        // Nilai total - gunakan SUM formula Excel (baris data mulai dari 6)
        $sheet->getStyle("F{$totalRow}")->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => '27124A'], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EDE7F6']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '27124A']]],
        ]);
        $sheet->getCell("F{$totalRow}")->setValue("=SUM(F6:F{$lastDataRow})");
        $sheet->getStyle("F{$totalRow}")->getNumberFormat()->setFormatCode('"Rp "#,##0');

        // Sisa kolom G–L baris total
        $sheet->mergeCells("G{$totalRow}:{$lastCol}{$totalRow}");
        $sheet->getStyle("G{$totalRow}:{$lastCol}{$totalRow}")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EDE7F6']],
        ]);

        // ── BARIS JUMLAH TRANSAKSI ────────────────────────────────────

        $countRow = $totalRow + 1;

        $sheet->mergeCells("A{$countRow}:E{$countRow}");
        $sheet->getStyle("A{$countRow}:E{$countRow}")->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3D1E6E']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getCell("A{$countRow}")->setValue('JUMLAH TRANSAKSI');
        $sheet->getRowDimension($countRow)->setRowHeight(22);

        $sheet->getStyle("F{$countRow}")->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '27124A'], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F0FA']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '27124A']]],
        ]);
        $sheet->getCell("F{$countRow}")->setValue("=COUNTA(A6:A{$lastDataRow})");
        $sheet->getStyle("F{$countRow}")->getNumberFormat()->setFormatCode('#,##0 "transaksi"');

        $sheet->mergeCells("G{$countRow}:{$lastCol}{$countRow}");
        $sheet->getStyle("G{$countRow}:{$lastCol}{$countRow}")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F0FA']],
        ]);

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