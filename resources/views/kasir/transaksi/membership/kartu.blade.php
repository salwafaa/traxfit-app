<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Member - {{ $transaction->member->nama }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&family=Libre+Barcode+39&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --deep: #27124A;
            --mid: #3a1d6b;
            --gold: #c9a84c;
            --gold-light: #e2c97e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Montserrat', sans-serif;
            background: #e0daea;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        @media print {
            body { background: white; padding: 0; display: block; }
            .no-print { display: none !important; }
            .card { box-shadow: none !important; margin: 0 auto; }
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 28px;
        }

        /* ── CARD ── */
        .card {
            width: 85.6mm;
            height: 54mm;
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            background: linear-gradient(150deg, #1c0b36 0%, #27124A 40%, #321860 70%, #27124A 100%);
            box-shadow:
                0 32px 64px rgba(39,18,74,0.55),
                0 0 0 1px rgba(201,168,76,0.3),
                inset 0 1px 0 rgba(255,255,255,0.1);
            color: white;
        }

        /* watermark TRAXFIT */
        .watermark {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .watermark-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 64px;
            font-weight: 700;
            letter-spacing: 12px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.045);
            white-space: nowrap;
            user-select: none;
            transform: rotate(-18deg);
        }

        /* top gold line */
        .gold-line {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 5%, var(--gold) 35%, var(--gold-light) 50%, var(--gold) 65%, transparent 95%);
            z-index: 10;
        }

        /* bottom gold line */
        .gold-line-bottom {
            position: absolute;
            bottom: 22px; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 5%, rgba(201,168,76,0.3) 30%, rgba(201,168,76,0.5) 50%, rgba(201,168,76,0.3) 70%, transparent 95%);
            z-index: 10;
        }

        /* subtle orb glow */
        .orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
        }
        .orb-1 {
            width: 130px; height: 130px;
            top: -50px; right: -30px;
            background: radial-gradient(circle, rgba(91,58,143,0.5) 0%, transparent 70%);
        }
        .orb-2 {
            width: 90px; height: 90px;
            bottom: 10px; left: 40px;
            background: radial-gradient(circle, rgba(201,168,76,0.1) 0%, transparent 70%);
        }

        /* ── HEADER ── */
        .card-header {
            position: absolute;
            top: 7px; left: 12px; right: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 5;
        }

        .gym-logo-area {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .gym-emblem {
            width: 20px; height: 20px;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(201,168,76,0.4);
        }

        .gym-emblem svg {
            width: 12px; height: 12px;
            fill: var(--deep);
        }

        .gym-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: white;
            line-height: 1;
        }

        .card-badge {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--gold);
            border: 1px solid rgba(201,168,76,0.45);
            padding: 3px 8px;
            border-radius: 20px;
            background: rgba(201,168,76,0.07);
        }

        /* header divider */
        .header-divider {
            position: absolute;
            top: 33px; left: 12px; right: 12px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.4), rgba(255,255,255,0.1), transparent);
            z-index: 5;
        }

        /* ── BODY LAYOUT ── */
        .card-body {
            position: absolute;
            top: 38px; left: 12px; right: 12px;
            bottom: 26px;
            display: flex;
            gap: 10px;
            z-index: 5;
            align-items: stretch;
        }

        /* ── PHOTO ── */
        .member-photo {
            width: 125px;
            flex-shrink: 0;
            border-radius: 6px;
            overflow: hidden;
            border: 1.5px solid rgba(201,168,76,0.5);
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(0,0,0,0.4);
        }

        .member-photo img {
            width: 100%; height: 100%;
            object-fit: cover;
        }

        .member-photo i {
            font-size: 28px;
            color: rgba(255,255,255,0.2);
        }

        /* ── INFO ── */
        .member-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            padding: 2px 0;
        }

        .member-top { display: flex; flex-direction: column; gap: 3px; }

        .member-name {
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.4px;
            line-height: 2.6;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .member-code {
            font-size: 7.5px;
            font-weight: 600;
            letter-spacing: 2px;
            color: var(--gold-light);
        }

        .member-details {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 7.5px;
            font-weight: 400;
            color: rgba(255,255,255,0.6);
            letter-spacing: 0.2px;
        }

        .detail-row i {
            font-size: 7px;
            color: var(--gold);
            width: 9px;
            text-align: center;
            flex-shrink: 0;
        }

        /* right column: chip + package */
        .card-right {
            width: 54px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
            padding: 2px 0;
        }

        /* chip */
        .chip {
            width: 28px; height: 20px;
            border-radius: 4px;
            background: linear-gradient(135deg, #d4a843 0%, #f0d890 40%, #c9a030 100%);
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            position: relative;
            overflow: hidden;
        }
        .chip::before {
            content: '';
            position: absolute;
            inset: 3px;
            border: 1px solid rgba(0,0,0,0.15);
            border-radius: 2px;
        }
        .chip::after {
            content: '';
            position: absolute;
            top: 50%; left: 0; right: 0;
            height: 1px;
            background: rgba(0,0,0,0.1);
            transform: translateY(-50%);
        }

        /* package pill */
        .package-pill {
            background: rgba(201,168,76,0.12);
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 4px;
            padding: 6px 8px;
            text-align: right;
        }
        .pkg-label {
            font-size: 5.5px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            display: block;
            line-height: 1;
            margin-bottom: 2px;
        }
        .pkg-value {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.3px;
            color: white;
            display: block;
            line-height: 1.2;
            white-space: nowrap;
        }

        /* ── FOOTER ── */
        .card-footer {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 22px;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            z-index: 5;
        }

        .footer-left {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .footer-dot {
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0.7;
        }

        .footer-valid-label {
            font-size: 6px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
        }

        .footer-valid-date {
            font-size: 8.5px;
            font-weight: 700;
            color: var(--gold-light);
            letter-spacing: 0.5px;
        }

        /* barcode */
        .barcode-wrap {
            opacity: 0.30;
        }
        .barcode-text {
            font-family: 'Libre Barcode 39', cursive;
            font-size: 14px;
            color: white;
            letter-spacing: -2px;
        }

        /* ── PAGE UI ── */
        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--deep);
            color: white;
            border: none;
            padding: 11px 28px;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(39,18,74,0.4);
            transition: all 0.2s ease;
        }
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(39,18,74,0.5);
        }

        .valid-note {
            font-size: 10px;
            color: rgba(39,18,74,0.45);
            letter-spacing: 0.3px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    <div class="card">
        <!-- Decoration -->
        <div class="watermark"><span class="watermark-text">TRAXFIT</span></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="gold-line"></div>
        <div class="gold-line-bottom"></div>

        <!-- Header -->
        <div class="card-header">
            <div class="gym-logo-area">
                <div class="gym-emblem">
                    {{-- Ganti dengan logo gym asli:
                    <img src="{{ asset('storage/logo.png') }}" style="width:100%;height:100%;object-fit:contain;border-radius:4px;" alt="Logo">
                    --}}
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/>
                    </svg>
                </div>
                <span class="gym-name">{{ $gymSettings->nama_gym ?? 'TRAXFIT' }}</span>
            </div>
            <span class="card-badge">Member Card</span>
        </div>

        <div class="header-divider"></div>

        <!-- Body -->
        <div class="card-body">
<!-- Photo -->
<div class="member-photo">
    <img src="{{ asset('images/logo/TRAX.PNG') }}" alt="Logo TRAX">
</div>

          <!-- Info -->
<div class="member-info">
    <div class="member-top">
        <div class="member-name">{{ $transaction->member->nama }}</div>
        <div class="member-code">{{ $transaction->member->kode_member }}</div>
    </div>
    <div class="member-details">
        <div class="detail-row">
            <i class="fas fa-id-card"></i>
            <span>{{ $transaction->member->jenis_identitas }}: {{ $transaction->member->no_identitas }}</span>
        </div>
        <div class="detail-row">
            <i class="fas fa-phone"></i>
            <span>{{ $transaction->member->telepon }}</span>
        </div>
        <div class="detail-row">
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ $transaction->member->alamat ?? 'Alamat tidak tersedia' }}</span>
        </div>
    </div>
</div>

            <!-- Right column -->
            <div class="card-right">
                <div class="chip"></div>
                <div class="package-pill">
                    <span class="pkg-label">Package</span>
                    <span class="pkg-value">{{ $transaction->member->package->nama_paket ?? '—' }}</span>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="card-footer">
            <div class="footer-left">
                <div class="footer-dot"></div>
                <span class="footer-valid-label">Valid Until&nbsp;</span>
                <span class="footer-valid-date">{{ $transaction->member->tgl_expired->format('d/m/Y') }}</span>
            </div>
            <div class="barcode-wrap">
                <span class="barcode-text">*{{ $transaction->member->kode_member }}*</span>
            </div>
        </div>

    </div>

    <!-- Print UI -->
    <div class="no-print" style="text-align:center;">
        <button onclick="window.print()" class="print-btn">
            <i class="fas fa-print"></i>&nbsp; Cetak Kartu Member
        </button>
        <div class="valid-note">Berlaku hingga {{ $transaction->member->tgl_expired->format('d F Y') }}</div>
    </div>

</div>
</body>
</html>