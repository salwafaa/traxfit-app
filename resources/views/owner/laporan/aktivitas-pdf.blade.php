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
            font-size: 10px;
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
            font-size: 20px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 9px;
        }
        .periode {
            margin-bottom: 10px;
            padding: 6px 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            font-size: 9px;
        }
        .filter {
            margin-bottom: 15px;
            padding: 6px 10px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 9px;
        }
        .filter strong {
            color: #27124A;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 8px;
        }
        .stat-card {
            flex: 1;
            min-width: 70px;
            padding: 6px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            text-align: center;
        }
        .stat-card h3 {
            margin: 0 0 3px 0;
            font-size: 8px;
            color: #666;
        }
        .stat-card p {
            margin: 0;
            font-size: 12px;
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
            padding: 6px 4px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
        }
        td {
            padding: 5px 4px;
            border-bottom: 1px solid #ddd;
            font-size: 8px;
            vertical-align: top;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .badge-admin {
            color: #dc2626;
            font-weight: bold;
        }
        .badge-kasir {
            color: #16a34a;
            font-weight: bold;
        }
        .badge-owner {
            color: #7c3aed;
            font-weight: bold;
        }
        .user-stats {
            margin-top: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
        }
        .user-stats h4 {
            margin-bottom: 8px;
            font-size: 10px;
            color: #27124A;
        }
        .user-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .user-item {
            flex: 1;
            min-width: 100px;
            padding: 5px;
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }
        .user-name {
            font-weight: bold;
            font-size: 9px;
        }
        .user-count {
            font-size: 10px;
            color: #27124A;
            font-weight: bold;
        }
        .user-role {
            font-size: 7px;
            color: #888;
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

    @if($filterText != 'Semua Data')
    <div class="filter">
        <strong>Filter:</strong> {{ $filterText }}
    </div>
    @endif

    <div class="stats">
        <div class="stat-card">
            <h3>Total Log</h3>
            <p>{{ number_format($totalLogs, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Login</h3>
            <p>{{ number_format($totalLogin, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Logout</h3>
            <p>{{ number_format($totalLogout, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Create</h3>
            <p>{{ number_format($totalCreate, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Update</h3>
            <p>{{ number_format($totalUpdate, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>Delete</h3>
            <p>{{ number_format($totalDelete, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <h3>View</h3>
            <p>{{ number_format($totalView, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background-color: #27124A;">
                    <th style="color: white;">No</th>
                    <th style="color: white;">Waktu</th>
                    <th style="color: white;">User</th>
                    <th style="color: white;">Role</th>
                    <th style="color: white;">Aktivitas</th>
                    <th style="color: white;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $index => $log)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $log->user->nama ?? 'Unknown' }}</td>
                    <td>
                        @if($log->role_user == 'admin')
                            <span class="badge-admin">Admin</span>
                        @elseif($log->role_user == 'kasir')
                            <span class="badge-kasir">Kasir</span>
                        @else
                            <span class="badge-owner">Owner</span>
                        @endif
                    </td>
                    <td>{{ $log->activity }}</td>
                    <td>{{ Str::limit($log->keterangan, 60) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 40px;">Tidak ada data aktivitas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($userStats->isNotEmpty())
    <div class="user-stats">
        <h4>Top User by Activity</h4>
        <div class="user-list">
            @foreach($userStats as $user)
            <div class="user-item">
                <div class="user-name">{{ $user['nama'] }}</div>
                <div class="user-count">{{ number_format($user['total'], 0, ',', '.') }} aktivitas</div>
                <div class="user-role">{{ $user['role'] == 'admin' ? 'Admin' : ($user['role'] == 'kasir' ? 'Kasir' : 'Owner') }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem. {{ $title }} - {{ $date }}</p>
    </div>
</body>
</html>