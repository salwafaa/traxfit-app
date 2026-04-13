<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            margin: 15px;
            background: white;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 3px solid #27124A;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #27124A;
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 10px;
        }
        .periode {
            margin-bottom: 15px;
            padding: 8px 12px;
            background-color: #f5f5f5;
            border-radius: 5px;
            font-size: 10px;
        }
        .periode strong {
            color: #27124A;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }
        .stat-card {
            flex: 1;
            padding: 8px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            text-align: center;
        }
        .stat-card h3 {
            margin: 0 0 5px 0;
            font-size: 10px;
            color: #666;
        }
        .stat-card p {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            color: #27124A;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #27124A;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
        }
        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
            vertical-align: top;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-bold {
            font-weight: bold;
        }
        .badge {
            background-color: #e0e0e0;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 8px;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Dicetak: {{ $date }}</p>
    </div>

    <div class="periode">
        <strong>Periode:</strong> {{ $periode }}
    </div>

    <div class="stats">
        <div class="stat-card">
            <h3>Total Transaksi</h3>
            <p>{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Pendapatan</h3>
            <p>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Pendapatan Tunai</h3>
            <p>Rp {{ number_format($totalPendapatanTunai, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Pendapatan Non-Tunai</h3>
            <p>Rp {{ number_format($totalPendapatanNonTunai, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background-color: #27124A;">
                    <th style="color: white;">No. Invoice</th>
                    <th style="color: white;">Tanggal</th>
                    <th style="color: white;">Jam</th>
                    <th style="color: white;">Kasir</th>
                    <th style="color: white;">Member</th>
                    <th style="color: white;" class="text-right">Total</th>
                    <th style="color: white;">Metode</th>
                    <th style="color: white;">Jenis</th>
                    <th style="color: white;">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td><strong>{{ $transaction->nomor_unik }}</strong></td>
                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                    <td>{{ $transaction->created_at->format('H:i') }}</td>
                    <td>{{ $transaction->user->nama ?? '-' }}</td>
                    <td>{{ $transaction->member->nama ?? 'Non-Member' }}</td>
                    <td class="text-right">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @if($transaction->metode_bayar == 'cash')
                            <span style="color: green;">Tunai</span>
                        @else
                            <span style="color: blue;">QRIS</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $jenisMap = [
                                'produk' => 'Produk',
                                'visit' => 'Visit',
                                'membership' => 'Membership',
                                'produk_visit' => 'Produk+Visit',
                                'produk_membership' => 'Produk+Member',
                            ];
                            $jenisText = $jenisMap[$transaction->jenis_transaksi] ?? '-';
                        @endphp
                        {{ $jenisText }}
                    </td>
                    <td style="font-size: 8px;">
                        @php
                            $dt = $transaction->data_tambahan ?? [];
                            // Normalise format membership dari dua controller yang berbeda
                            $paketNested = $dt['paket_membership'] ?? null;
                            $namaPaket   = $paketNested['nama']       ?? $dt['nama_paket']  ?? null;
                            $hargaPaket  = $paketNested['harga']      ?? $dt['harga_paket'] ?? null;
                            $durasiHari  = $paketNested['durasi_hari'] ?? $dt['durasi_hari'] ?? null;
                            $tglMulai    = $dt['tgl_mulai']   ?? null;
                            $tglSelesai  = $dt['tgl_selesai'] ?? null;
                            $hargaVisit  = $dt['harga_visit'] ?? null;
                            $tglVisit    = $dt['tgl_visit']   ?? null;
                        @endphp

                        {{-- VISIT --}}
                        @if($transaction->isVisitOnly() || $transaction->isProdukDanVisit())
                            @if($hargaVisit !== null)
                                Visit: Rp {{ number_format((float)$hargaVisit, 0, ',', '.') }}
                            @endif
                            @if($tglVisit)
                                <br>Tgl: {{ \Carbon\Carbon::parse($tglVisit)->format('d/m/Y') }}
                            @endif
                        @endif

                        {{-- MEMBERSHIP --}}
                        @if($transaction->isMembershipOnly() || $transaction->isProdukDanMembership())
                            @if($namaPaket)
                                Paket: {{ $namaPaket }}
                            @endif
                            @if($hargaPaket !== null)
                                <br>Harga: Rp {{ number_format((float)$hargaPaket, 0, ',', '.') }}
                            @endif
                            @if($durasiHari)
                                <br>Durasi: {{ $durasiHari }} hari
                            @endif
                            @if($tglMulai)
                                <br>Mulai: {{ \Carbon\Carbon::parse($tglMulai)->format('d/m/Y') }}
                            @endif
                            @if($tglSelesai)
                                <br>Selesai: {{ \Carbon\Carbon::parse($tglSelesai)->format('d/m/Y') }}
                            @endif
                            @if(!empty($dt['is_renewal']))
                                <br><em>Perpanjangan</em>
                            @endif
                        @endif

                        {{-- PRODUK (semua jenis yang mengandung produk) --}}
                        @if($transaction->details->isNotEmpty())
                            @if($transaction->isProdukOnly() || $transaction->isProdukDanVisit() || $transaction->isProdukDanMembership())
                                @if(!$transaction->isVisitOnly() && !$transaction->isMembershipOnly())
                                    <br>
                                @endif
                                @foreach($transaction->details as $detail)
                                    {{ $detail->product->nama_produk ?? 'Produk' }} x{{ $detail->qty }}
                                    (Rp {{ number_format($detail->subtotal, 0, ',', '.') }})
                                    @if(!$loop->last)<br>@endif
                                @endforeach
                            @endif
                        @endif

                        @if(empty($dt) && $transaction->details->isEmpty())
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 40px;">Tidak ada data transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem. {{ $title }} - {{ $date }}</p>
    </div>
</body>
</html>