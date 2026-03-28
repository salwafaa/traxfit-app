<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaction->nomor_unik }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        @media print {
            body { 
                font-family: 'Courier New', monospace;
                font-size: 11px;
                line-height: 1.2;
                margin: 0;
                padding: 5px;
                background: white;
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
            }
            .receipt {
                max-width: 100%;
                width: 100%;
                margin: 0;
                padding: 10px 5px;
                box-shadow: none;
                border: none;
            }
            .no-print { display: none !important; }
            .info-row, .service-row, .total-row {
                flex-wrap: wrap;
                word-break: break-word;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            max-width: 320px;
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            background: #f9f9f9;
            overflow-x: hidden;
            word-wrap: break-word;
        }
        
        .receipt {
            background: white;
            border-radius: 12px;
            padding: 15px 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px dashed #e0e0e0;
            padding-bottom: 12px;
            margin-bottom: 12px;
            width: 100%;
        }
        
        .title {
            font-weight: bold;
            font-size: 16px;
            color: #27124A;
            letter-spacing: 0.5px;
            word-break: break-word;
        }
        
        .address {
            font-size: 9px;
            color: #888;
            margin: 2px 0;
            word-break: break-word;
        }
        
        .transaction-info {
            margin: 12px 0;
            padding: 8px;
            background: #f8f5ff;
            border-radius: 10px;
            border: 1px solid #e0d5f0;
            width: 100%;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 10px;
            flex-wrap: wrap;
            width: 100%;
        }
        
        .info-label {
            color: #555;
            white-space: nowrap;
        }
        
        .info-value {
            font-weight: bold;
            color: #27124A;
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }
        
        .items {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            font-size: 10px;
            table-layout: fixed;
        }
        
        .items th {
            border-bottom: 1px dashed #ccc;
            padding: 6px 2px;
            text-align: left;
            color: #27124A;
            font-size: 10px;
        }
        
        .items td {
            padding: 4px 2px;
            border-bottom: 1px dashed #f0f0f0;
            word-break: break-word;
        }
        
        .items .text-right {
            text-align: right;
        }
        
        .items th:first-child, .items td:first-child {
            width: 35%;
        }
        
        .items th:nth-child(2), .items td:nth-child(2) {
            width: 15%;
            text-align: center;
        }
        
        .items th:nth-child(3), .items td:nth-child(3) {
            width: 20%;
            text-align: right;
        }
        
        .items th:nth-child(4), .items td:nth-child(4) {
            width: 30%;
            text-align: right;
        }
        
        .service-section {
            margin: 12px 0;
            padding: 8px;
            background: #f0f7ff;
            border-radius: 10px;
            border: 1px solid #d0e0ff;
            width: 100%;
        }
        
        .service-title {
            font-weight: bold;
            color: #27124A;
            margin-bottom: 6px;
            font-size: 11px;
        }
        
        .service-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 10px;
            flex-wrap: wrap;
        }
        
        .service-row span:last-child {
            max-width: 60%;
            word-break: break-word;
            text-align: right;
        }
        
        .total-section {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 2px dashed #27124A;
            width: 100%;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 11px;
            flex-wrap: wrap;
        }
        
        .total-row span:last-child {
            max-width: 60%;
            word-break: break-word;
            text-align: right;
        }
        
        .grand-total {
            font-weight: bold;
            font-size: 13px;
            color: #27124A;
            border-top: 1px solid #ccc;
            padding-top: 6px;
            margin-top: 6px;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 12px;
            border-top: 2px dashed #e0e0e0;
            font-size: 9px;
            color: #666;
            width: 100%;
        }
        
        .thank-you {
            font-weight: bold;
            color: #27124A;
            font-size: 13px;
            margin-bottom: 4px;
            word-break: break-word;
        }
        
        .divider {
            text-align: center;
            letter-spacing: 2px;
            color: #ccc;
            margin: 8px 0;
        }
        
        .print-button {
            background: #27124A;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            margin: 5px;
        }
        
        .close-button {
            background: #e0e0e0;
            color: #333;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            margin: 5px;
        }
        
        .button-container {
            margin-top: 15px;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="title">{{ $gymSettings->nama_gym ?? 'TRAXFIT GYM' }}</div>
            @if(isset($gymSettings) && $gymSettings->alamat)
            <div class="address">{{ $gymSettings->alamat }}</div>
            @endif
            @if(isset($gymSettings) && $gymSettings->telepon)
            <div class="address">Telp: {{ $gymSettings->telepon }}</div>
            @endif
            <div class="divider">✦ ✦ ✦ ✦ ✦</div>
        </div>
        
        <!-- Transaction Info -->
        <div class="transaction-info">
            <div class="info-row">
                <span class="info-label">No. Transaksi</span>
                <span class="info-value">#{{ $transaction->nomor_unik }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kasir</span>
                <span class="info-value">{{ $transaction->user->nama ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jenis</span>
                <span class="info-value">
                    @php
                        $jenisLabels = [
                            'produk' => 'Produk',
                            'visit' => 'Visit',
                            'membership' => 'Membership',
                            'produk_visit' => 'Produk + Visit',
                            'produk_membership' => 'Produk + Membership'
                        ];
                    @endphp
                    {{ $jenisLabels[$transaction->jenis_transaksi] ?? $transaction->jenis_transaksi }}
                </span>
            </div>
            @if($transaction->member)
            <div class="info-row">
                <span class="info-label">Member</span>
                <span class="info-value">{{ $transaction->member->kode_member ?? '' }} - {{ $transaction->member->nama ?? '' }}</span>
            </div>
            @endif
        </div>

        <!-- Visit Section -->
        @if($transaction->isVisitOnly() || $transaction->isProdukDanVisit())
        @php
            $dataVisit = $transaction->data_visit;
        @endphp
        <div class="service-section">
            <div class="service-title">🏃‍♂️ VISIT GYM</div>
            <div class="service-row">
                <span>Harga Visit</span>
                <span>Rp {{ number_format($dataVisit['harga_visit'] ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="service-row">
                <span>Tanggal</span>
                <span>{{ isset($dataVisit['tgl_visit']) ? \Carbon\Carbon::parse($dataVisit['tgl_visit'])->format('d/m/Y H:i') : '-' }}</span>
            </div>
        </div>
        @endif

        <!-- Membership Section -->
        @if($transaction->isMembershipOnly() || $transaction->isProdukDanMembership())
        @php
            $dataMembership = $transaction->data_membership;
            
            // Fallback jika data masih kosong (untuk transaksi lama)
            if (empty($dataMembership['harga_paket']) || $dataMembership['harga_paket'] == 0) {
                // Cari paket berdasarkan ID yang tersimpan di member
                $paket = null;
                if ($transaction->member && $transaction->member->id_paket) {
                    $paket = \App\Models\MembershipPackage::find($transaction->member->id_paket);
                }
                
                // Jika tidak ketemu, coba cari berdasarkan total harga
                if (!$paket) {
                    $paket = \App\Models\MembershipPackage::where('harga', $transaction->total_harga)->first();
                }
                
                $dataMembership = [
                    'id_paket' => $transaction->member->id_paket ?? null,
                    'nama_paket' => $paket ? $paket->nama_paket : ($transaction->member->paket_nama ?? 'Paket Membership'),
                    'durasi_hari' => $paket ? $paket->durasi_hari : 30,
                    'harga_paket' => $paket ? $paket->harga : ($transaction->total_harga ?? 0),
                    'tgl_mulai' => $transaction->created_at,
                    'tgl_selesai' => $transaction->member->tgl_expired ?? $transaction->created_at->addDays(30),
                ];
            }
        @endphp
        <div class="service-section">
            <div class="service-title">🎫 MEMBERSHIP</div>
            <div class="service-row">
                <span>Paket</span>
                <span>{{ $dataMembership['nama_paket'] }}</span>
            </div>
            <div class="service-row">
                <span>Durasi</span>
                <span>{{ $dataMembership['durasi_hari'] }} Hari</span>
            </div>
            <div class="service-row">
                <span>Harga Paket</span>
                <span>Rp {{ number_format($dataMembership['harga_paket'], 0, ',', '.') }}</span>
            </div>
            <div class="service-row">
                <span>Mulai</span>
                <span>{{ isset($dataMembership['tgl_mulai']) ? \Carbon\Carbon::parse($dataMembership['tgl_mulai'])->format('d/m/Y H:i') : ($transaction->created_at ? $transaction->created_at->format('d/m/Y H:i') : '-') }}</span>
            </div>
            <div class="service-row">
                <span>Selesai</span>
                <span>{{ isset($dataMembership['tgl_selesai']) ? \Carbon\Carbon::parse($dataMembership['tgl_selesai'])->format('d/m/Y H:i') : ($transaction->member && $transaction->member->tgl_expired ? \Carbon\Carbon::parse($transaction->member->tgl_expired)->format('d/m/Y H:i') : '-') }}</span>
            </div>
        </div>
        @endif
        
        <!-- Items -->
        @if($transaction->details && $transaction->details->count() > 0)
        <table class="items">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product ? Str::limit($detail->product->nama_produk, 20) : 'Produk tidak ditemukan' }}</td>
                    <td class="text-right">{{ $detail->qty }}</td>
                    <td class="text-right">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        
        <!-- Totals -->
        <div class="total-section">
            @php
                $subtotalProduk = $transaction->details ? $transaction->details->sum('subtotal') : 0;
                $dataTambahan = $transaction->data_tambahan ?? [];
                $biayaVisit = $dataTambahan['harga_visit'] ?? 0;
                $biayaMembership = $dataTambahan['harga_paket'] ?? 0;
                
                // Untuk transaksi lama, gunakan total_harga sebagai harga paket
                if ($transaction->isMembershipOnly() && $biayaMembership == 0) {
                    $biayaMembership = $transaction->total_harga;
                }
            @endphp

            @if($subtotalProduk > 0)
            <div class="total-row">
                <span>Subtotal Produk</span>
                <span>Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
            </div>
            @endif

            @if($biayaVisit > 0)
            <div class="total-row">
                <span>Biaya Visit</span>
                <span>Rp {{ number_format($biayaVisit, 0, ',', '.') }}</span>
            </div>
            @endif

            @if($biayaMembership > 0)
            <div class="total-row">
                <span>Biaya Membership</span>
                <span>Rp {{ number_format($biayaMembership, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="total-row grand-total">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->total_harga ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Uang Bayar</span>
                <span>Rp {{ number_format($transaction->uang_bayar ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Uang Kembali</span>
                <span>Rp {{ number_format($transaction->uang_kembali ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">TERIMA KASIH</div>
            <div>Atas kunjungan Anda</div>
            <div class="divider">✦ ✦ ✦ ✦ ✦</div>
            <div style="font-size: 8px;">Soft copy • {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</div>
        </div>
    </div>
    
    <!-- Print Button -->
    <div class="button-container no-print">
        <button onclick="window.print()" class="print-button">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <button onclick="window.close()" class="close-button">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>
    
    <script>
        window.onload = function() {
            // Auto print setelah load, tapi dengan delay lebih lama
            setTimeout(function() {
                if (window.matchMedia) {
                    var mediaQueryList = window.matchMedia('print');
                    mediaQueryList.addListener(function(mql) {
                        if (!mql.matches) {
                            // Setelah print dialog ditutup
                        }
                    });
                }
                window.print();
            }, 800);
        };
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>