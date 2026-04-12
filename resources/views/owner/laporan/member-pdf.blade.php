<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #27124A;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
            color: #27124A;
        }
        .header h3 {
            font-size: 14px;
            margin: 5px 0;
            color: #666;
        }
        .header p {
            font-size: 11px;
            margin: 3px 0;
            color: #999;
        }
        .info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-left: 4px solid #27124A;
            font-size: 11px;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
            gap: 10px;
        }
        .stat-card {
            flex: 1;
            min-width: 120px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            text-align: center;
        }
        .stat-card .label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }
        .stat-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #27124A;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        th {
            background-color: #27124A;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }
        .status-active {
            color: #10b981;
            font-weight: bold;
        }
        .status-pending {
            color: #f59e0b;
            font-weight: bold;
        }
        .status-expired {
            color: #ef4444;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-active {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-pending {
            background-color: #fed7aa;
            color: #9b2c1d;
        }
        .badge-expired {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <h3>{{ $gymName ?? 'Gym Management System' }}</h3>
        <p>Dicetak: {{ $date }}</p>
        @if($filterText != 'Semua Data')
            <p><strong>Filter:</strong> {{ $filterText }}</p>
        @endif
    </div>

    <div class="info">
        <strong>Informasi Laporan:</strong> Menampilkan data member gym dengan filter yang diterapkan.
        Total member: {{ number_format($totalMember, 0, ',', '.') }} member.
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="label">Total Member</div>
            <div class="value">{{ number_format($totalMember, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Member Aktif</div>
            <div class="value">{{ number_format($memberAktif, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Akan Expired (≤7 hari)</div>
            <div class="value">{{ number_format($expiringSoon, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Member Expired</div>
            <div class="value">{{ number_format($memberExpired, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Member Pending</div>
            <div class="value">{{ number_format($memberPending, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Total Check-in</div>
            <div class="value">{{ number_format($totalCheckins, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Member</th>
                <th>Telepon</th>
                <th>Paket</th>
                <th>Tgl Daftar</th>
                <th>Tgl Expired</th>
                <th>Sisa Hari</th>
                <th>Check-in</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $member)
                @php
                    $sisaHari = 0;
                    if ($member->tgl_expired) {
                        $sisaHari = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($member->tgl_expired), false);
                        $sisaHari = $sisaHari < 0 ? 0 : $sisaHari;
                    }
                    
                    $statusClass = '';
                    $statusText = '';
                    if ($member->status == 'active' && $sisaHari > 0) {
                        $statusClass = 'status-active';
                        $statusText = 'Aktif';
                    } elseif ($member->status == 'pending') {
                        $statusClass = 'status-pending';
                        $statusText = 'Pending';
                    } else {
                        $statusClass = 'status-expired';
                        $statusText = 'Expired';
                    }
                    
                    $sisaHariText = '';
                    if ($sisaHari > 0) {
                        $sisaHariText = $sisaHari . ' hari';
                    } elseif ($sisaHari == 0 && $member->tgl_expired) {
                        $sisaHariText = 'Hari ini';
                    } else {
                        $sisaHariText = 'Expired';
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->telepon ?? '-' }}</td>
                    <td>{{ $member->package ? $member->package->nama_paket : '-' }}</td>
                    <td class="text-center">{{ $member->tgl_daftar ? \Carbon\Carbon::parse($member->tgl_daftar)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">{{ $member->tgl_expired ? \Carbon\Carbon::parse($member->tgl_expired)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">{{ $sisaHariText }}</td>
                    <td class="text-center">{{ $member->checkins_count ?? 0 }}</td>
                    <td class="{{ $statusClass }}">{{ $statusText }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px;">
                        Tidak ada data member yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem pada {{ $date }}</p>
        <p>* Data member yang ditampilkan sesuai dengan filter yang dipilih</p>
    </div>
</body>
</html>