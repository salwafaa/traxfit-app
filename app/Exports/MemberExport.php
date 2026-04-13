<?php

namespace App\Exports;

use App\Models\Member;
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

class MemberExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected $members;
    protected $filterInfo;

    public function __construct($members, $filterInfo = null)
    {
        $this->members = $members;
        $this->filterInfo = $filterInfo;
    }

    public function collection()
    {
        return $this->members;
    }

    public function title(): string
    {
        return 'Data Member';
    }

    public function headings(): array
    {
        $cols = 10; // berkurang dari 12 → 10 (hapus EMAIL & TERDAFTAR OLEH)
        $merge = array_fill(0, $cols, '');

        return [
            array_merge(['TRAXFIT GYM'], array_slice($merge, 1)),
            array_merge(['Laporan Data Member'], array_slice($merge, 1)),
            array_merge([$this->filterInfo ?? ('Diekspor pada: ' . Carbon::now()->format('d/m/Y H:i:s'))], array_slice($merge, 1)),
            $merge,
            [
                'NO', 'NAMA MEMBER', 'NOMOR TELEPON',
                'ALAMAT', 'PAKET', 'TANGGAL DAFTAR', 'TANGGAL EXPIRED',
                'SISA HARI', 'JUMLAH CHECK-IN', 'STATUS',
            ],
        ];
    }

    public function map($member): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $sisaHari = 0;
        if ($member->tgl_expired) {
            $sisaHari = Carbon::now()->diffInDays(Carbon::parse($member->tgl_expired), false);
            $sisaHari = $sisaHari < 0 ? 0 : $sisaHari;
        }

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
            $member->alamat ?? '-',
            $member->package ? $member->package->nama_paket : '-',
            $member->tgl_daftar ? Carbon::parse($member->tgl_daftar)->format('d/m/Y') : '-',
            $member->tgl_expired ? Carbon::parse($member->tgl_expired)->format('d/m/Y') : '-',
            $sisaHari > 0 ? $sisaHari . ' hari' : ($sisaHari == 0 && $member->tgl_expired ? 'Hari ini' : 'Expired'),
            $member->checkins_count ?? 0,
            $statusText,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastCol = 'J'; // sebelumnya L, sekarang J (10 kolom)

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

            // Warna status di kolom J (kolom ke-10, sebelumnya K/ke-11)
            $statusCell = "J{$row}";
            $statusVal  = $sheet->getCell($statusCell)->getValue();
            if ($statusVal === 'Aktif') {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '1A7A3C']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D4EDDA']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            } elseif ($statusVal === 'Expired') {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'A00000']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FDDEDE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            } elseif ($statusVal === 'Pending') {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '7A5C00']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF3CD']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }
        }

        // Kolom NO rata tengah (A)
        $sheet->getStyle("A6:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Kolom Check-In rata tengah (I, sebelumnya J)
        $sheet->getStyle("I6:I{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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