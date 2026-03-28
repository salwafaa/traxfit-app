<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaction->nomor_unik }}</title>
    <style>
        /* Sama seperti sebelumnya */
        @media print {
            body { 
                font-family: 'Courier New', monospace;
                font-size: 12px;
                line-height: 1.3;
                margin: 0;
                padding: 10px;
                background: white;
            }
            .no-print { display: none !important; }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-width: 300px;
            margin: 0 auto;
            padding: 15px;
            background: #f9f9f9;
        }
        
        .receipt {
            background: white;
            border-radius: 16px;
            padding: 20px 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px dashed #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .title {
            font-weight: bold;
            font-size: 18px;
            color: #27124A;
            letter-spacing: 1px;
        }
        
        .address {
            font-size: 10px;
            color: #888;
            margin: 3px 0;
        }
        
        .transaction-info {
            margin: 15px 0;
            padding: 10px;
            background: #f8f5ff;
            border-radius: 12px;
            border: 1px solid #e0d5f0;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        .info-label {
            color: #555;
        }
        
        .info-value {
            font-weight: bold;
            color: #27124A;
        }
        
        .items {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px;
        }
        
        .items th {
            border-bottom: 1px dashed #ccc;
            padding: 8px 0;
            text-align: left;
            color: #27124A;
        }
        
        .items td {
            padding: 6px 0;
            border-bottom: 1px dashed #f0f0f0;
        }
        
        .items .text-right {
            text-align: right;
        }
        
        .service-section {
            margin: 15px 0;
            padding: 10px;
            background: #f0f7ff;
            border-radius: 12px;
            border: 1px solid #d0e0ff;
        }
        
        .service-title {
            font-weight: bold;
            color: #27124A;
            margin-bottom: 8px;
            font-size: 12px;
        }
        
        .service-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        .total-section {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px dashed #27124A;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 12px;
        }
        
        .grand-total {
            font-weight: bold;
            font-size: 14px;
            color: #27124A;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            margin-top: 8px;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #e0e0e0;
            font-size: 10px;
            color: #666;
        }
        
        .thank-you {
            font-weight: bold;
            color: #27124A;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .divider {
            text-align: center;
            letter-spacing: 2px;
            color: #ccc;
            margin: 10px 0;
        }
        
        .print-button {
            background: #27124A;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            margin: 10px 5px;
        }
        
        .close-button {
            background: #e0e0e0;
            color: #333;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            margin: 10px 5px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="title">{{ $gymSettings->nama_gym ?? 'TRAXFIT GYM' }}</div>
            @if($gymSettings && $gymSettings->alamat)
            <div class="address">{{ $gymSettings->alamat }}</div>
            @endif
            @if($gymSettings && $gymSettings->telepon)
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
                <span class="info-value">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kasir</span>
                <span class="info-value">{{ $transaction->user->nama }}</span>
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
                <span class="info-value">{{ $transaction->member->kode_member }} - {{ $transaction->member->nama }}</span>
            </div>
            @endif
        </div>

        <!-- Visit Section -->
        @if($transaction->isVisitOnly() || $transaction->isProdukDanVisit())
        <div class="service-section">
            <div class="service-title">🏃‍♂️ VISIT GYM</div>
            <div class="service-row">
                <span>Harga Visit</span>
                <span>Rp {{ number_format($transaction->data_tambahan['harga_visit'] ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="service-row">
                <span>Tanggal</span>
                <span>{{ isset($transaction->data_tambahan['tgl_visit']) ? \Carbon\Carbon::parse($transaction->data_tambahan['tgl_visit'])->format('d/m/Y H:i') : '-' }}</span>
            </div>
        </div>
        @endif

        <!-- Membership Section -->
        @if($transaction->isMembershipOnly() || $transaction->isProdukDanMembership())
        <div class="service-section">
            <div class="service-title">🎫 MEMBERSHIP</div>
            <div class="service-row">
                <span>Paket</span>
                <span>{{ $transaction->data_tambahan['nama_paket'] ?? '-' }}</span>
            </div>
            <div class="service-row">
                <span>Durasi</span>
                <span>{{ $transaction->data_tambahan['durasi_hari'] ?? 0 }} Hari</span>
            </div>
            <div class="service-row">
                <span>Harga Paket</span>
                <span>Rp {{ number_format($transaction->data_tambahan['harga_paket'] ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="service-row">
                <span>Mulai</span>
                <span>{{ isset($transaction->data_tambahan['tgl_mulai']) ? \Carbon\Carbon::parse($transaction->data_tambahan['tgl_mulai'])->format('d/m/Y H:i') : '-' }}</span>
            </div>
            <div class="service-row">
                <span>Selesai</span>
                <span>{{ isset($transaction->data_tambahan['tgl_selesai']) ? \Carbon\Carbon::parse($transaction->data_tambahan['tgl_selesai'])->format('d/m/Y H:i') : '-' }}</span>
            </div>
        </div>
        @endif
        
        <!-- Items -->
        @if($transaction->details->count() > 0)
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
                    <td>{{ $detail->product->nama_produk }}</td>
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
                $subtotalProduk = $transaction->details->sum('subtotal');
                $biayaVisit = $transaction->data_tambahan['harga_visit'] ?? 0;
                $biayaMembership = $transaction->data_tambahan['harga_paket'] ?? 0;
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
                <span>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Uang Bayar</span>
                <span>Rp {{ number_format($transaction->uang_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Uang Kembali</span>
                <span>Rp {{ number_format($transaction->uang_kembali, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">TERIMA KASIH</div>
            <div>Atas kunjungan Anda</div>
            <div class="divider">✦ ✦ ✦ ✦ ✦</div>
            <div style="font-size: 9px;">Soft copy • {{ now()->format('d/m/Y H:i:s') }}</div>
        </div>
    </div>
    
    <!-- Print Button -->
    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" class="print-button">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <button onclick="window.close()" class="close-button">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>
    
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>