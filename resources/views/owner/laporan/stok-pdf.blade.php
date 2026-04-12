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
        .filter {
            margin-bottom: 15px;
            padding: 8px 12px;
            background-color: #f5f5f5;
            border-radius: 5px;
            font-size: 10px;
        }
        .filter strong {
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
        .stat-card .small {
            font-size: 10px;
            color: #888;
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
        .table-responsive {
            overflow-x: auto;
        }
        .status-habis {
            color: #dc2626;
            font-weight: bold;
        }
        .status-menipis {
            color: #eab308;
            font-weight: bold;
        }
        .status-tersedia {
            color: #22c55e;
            font-weight: bold;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Dicetak: {{ $date }}</p>
    </div>

    <div class="filter">
        <strong>Filter:</strong> {{ $filterText }}
    </div>

    <div class="stats">
        <div class="stat-card">
            <h3>Total Produk</h3>
            <p>{{ number_format($totalProduk, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Stok</h3>
            <p>{{ number_format($totalStok, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Nilai Stok</h3>
            <p>Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Tersedia</h3>
            <p>{{ number_format($produkTersedia, 0, ',', '.') }}</p>
            <span class="small">Stok >5</span>
        </div>
        <div class="stat-card">
            <h3>Menipis</h3>
            <p>{{ number_format($produkHampirHabis, 0, ',', '.') }}</p>
            <span class="small">Stok 1-5</span>
        </div>
        <div class="stat-card">
            <h3>Habis</h3>
            <p>{{ number_format($produkHabis, 0, ',', '.') }}</p>
            <span class="small">Stok 0</span>
        </div>
    </div>

    <div class="table-responsive">
         <table
            <thead>
                <tr style="background-color: #27124A;">
                    <th style="color: white;">No</th>
                    <th style="color: white;">Nama Produk</th>
                    <th style="color: white;">Kategori</th>
                    <th style="color: white;" class="text-right">Harga</th>
                    <th style="color: white;" class="text-right">Stok</th>
                    <th style="color: white;">Status Stok</th>
                    <th style="color: white;">Status Produk</th>
                    <th style="color: white;">Tgl Ditambahkan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->nama_produk }}</td>
                    <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $product->stok }}</td>
                    <td>
                        @if($product->stok == 0)
                            <span class="status-habis">Habis</span>
                        @elseif($product->stok <= 5)
                            <span class="status-menipis">Menipis</span>
                        @else
                            <span class="status-tersedia">Tersedia</span>
                        @endif
                    </td>
                    <td>
                        @if($product->status)
                            <span style="color: #22c55e;">Aktif</span>
                        @else
                            <span style="color: #9ca3af;">Non-Aktif</span>
                        @endif
                    </td>
                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 40px;">Tidak ada data produk</td>
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