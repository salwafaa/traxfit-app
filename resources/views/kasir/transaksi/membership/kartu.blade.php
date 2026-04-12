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

        /* ===================== CARD ===================== */
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
            font-size: 72px;
            font-weight: 700;
            letter-spacing: 14px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.04);
            white-space: nowrap;
            user-select: none;
            transform: rotate(-15deg);
        }

        .gold-line {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 5%, var(--gold) 35%, var(--gold-light) 50%, var(--gold) 65%, transparent 95%);
            z-index: 10;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
        }
        .orb-1 {
            width: 140px; height: 140px;
            top: -60px; right: -40px;
            background: radial-gradient(circle, rgba(91,58,143,0.5) 0%, transparent 70%);
        }
        .orb-2 {
            width: 100px; height: 100px;
            bottom: -30px; left: 10px;
            background: radial-gradient(circle, rgba(201,168,76,0.1) 0%, transparent 70%);
        }
        .orb-3 {
            width: 70px; height: 70px;
            top: 5px; left: -15px;
            background: radial-gradient(circle, rgba(100,60,180,0.3) 0%, transparent 70%);
        }

        /* dot grid — right side texture */
        .dot-grid {
            position: absolute;
            top: 36px; right: 0; bottom: 24px;
            width: 65px;
            z-index: 2;
            pointer-events: none;
            overflow: hidden;
            opacity: 0.14;
        }
        .dot-grid svg { width: 100%; height: 100%; }

        /* corner bracket accents */
        .corner-accent { position: absolute; z-index: 3; pointer-events: none; }
        .corner-tl { top: 37px; left: 0; }
        .corner-br { bottom: 24px; right: 0; }
        .corner-accent svg { width: 20px; height: 20px; }

        /* ===================== HEADER ===================== */
        .card-header {
            position: absolute;
            top: 8px; left: 14px; right: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 5;
        }

        .gym-logo-area { display: flex; align-items: center; gap: 7px; }

        .gym-emblem {
            width: 22px; height: 22px;
            border-radius: 5px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(201,168,76,0.45);
        }
        .gym-emblem svg { width: 13px; height: 13px; fill: var(--deep); }

        .gym-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 15px; font-weight: 700;
            letter-spacing: 3px; text-transform: uppercase;
            color: white; line-height: 1;
        }

        .card-badge {
            font-size: 8.5px; font-weight: 700;
            letter-spacing: 1.8px; text-transform: uppercase;
            color: var(--gold);
            border: 1px solid rgba(201,168,76,0.4);
            padding: 3px 9px; border-radius: 20px;
            background: rgba(201,168,76,0.07);
        }

        .header-divider {
            position: absolute;
            top: 35px; left: 14px; right: 14px; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.35), rgba(255,255,255,0.08), transparent);
            z-index: 5;
        }

        /* ===================== BODY ===================== */
        .card-body {
            position: absolute;
            top: 42px; left: 14px; right: 14px; bottom: 26px;
            display: flex; gap: 0; z-index: 5; align-items: stretch;
        }

        /* avatar column */
        .member-avatar-col {
            width: 44px; flex-shrink: 0;
            display: flex; flex-direction: column;
            align-items: center; justify-content: flex-start;
            padding-top: 3px;
        }
        .member-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1.5px solid rgba(201,168,76,0.55);
            background: linear-gradient(135deg, rgba(201,168,76,0.15) 0%, rgba(100,60,180,0.22) 100%);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.35);
        }
        .avatar-initials {
            font-family: 'Cormorant Garamond', serif;
            font-size: 14px; font-weight: 700;
            color: var(--gold-light);
            letter-spacing: 0.5px; line-height: 1;
        }
        .avatar-line {
            width: 1px; flex: 1; margin-top: 5px;
            background: linear-gradient(to bottom, rgba(201,168,76,0.3), transparent);
        }

        /* vertical dividers */
        .v-divider {
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(201,168,76,0.28), transparent);
            margin: 4px 9px; flex-shrink: 0;
        }

        /* member info */
        .member-info {
            flex: 1; display: flex; flex-direction: column;
            justify-content: space-between; min-width: 0; padding: 3px 0;
        }
        .member-name {
            font-size: 11px; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: white; white-space: nowrap;
            overflow: hidden; text-overflow: ellipsis; line-height: 1.2;
        }
        .member-code {
            font-size: 7.5px; font-weight: 600;
            letter-spacing: 2.2px; color: var(--gold-light); margin-top: 3px;
        }
        .member-details { display: flex; flex-direction: column; gap: 3.5px; }
        .detail-row {
            display: flex; align-items: center; gap: 5px;
            font-size: 7.5px; color: rgba(255,255,255,0.5); letter-spacing: 0.2px;
        }
        .detail-row i {
            font-size: 7px; color: var(--gold);
            width: 9px; text-align: center; flex-shrink: 0;
        }

        /* right column */
        .card-right {
            width: 56px; flex-shrink: 0;
            display: flex; flex-direction: column;
            align-items: flex-end; justify-content: space-between; padding: 3px 0;
        }
        .chip {
            width: 30px; height: 22px; border-radius: 4px;
            background: linear-gradient(135deg, #d4a843 0%, #f0d890 40%, #c9a030 100%);
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            position: relative; overflow: hidden;
        }
        .chip::before {
            content: ''; position: absolute; inset: 3px;
            border: 1px solid rgba(0,0,0,0.15); border-radius: 2px;
        }
        .chip::after {
            content: ''; position: absolute;
            top: 50%; left: 0; right: 0; height: 1px;
            background: rgba(0,0,0,0.1); transform: translateY(-50%);
        }
        .package-pill {
            background: rgba(201,168,76,0.1);
            border: 1px solid rgba(201,168,76,0.28);
            border-radius: 5px; padding: 5px 8px; text-align: right;
        }
        .pkg-label {
            font-size: 5.5px; font-weight: 700;
            letter-spacing: 1.2px; text-transform: uppercase;
            color: rgba(255,255,255,0.3); display: block; margin-bottom: 2px;
        }
        .pkg-value {
            font-size: 8.5px; font-weight: 700;
            color: white; display: block; line-height: 1.2; white-space: nowrap;
        }

        /* ===================== FOOTER ===================== */
        .card-footer {
            position: absolute; bottom: 0; left: 0; right: 0; height: 24px;
            background: rgba(0,0,0,0.28);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 14px; z-index: 5;
        }
        .footer-left { display: flex; align-items: center; gap: 6px; }
        .footer-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--gold); opacity: 0.7; }
        .footer-valid-label {
            font-size: 6px; font-weight: 600; letter-spacing: 1.2px;
            text-transform: uppercase; color: rgba(255,255,255,0.3);
        }
        .footer-valid-date { font-size: 9px; font-weight: 700; color: var(--gold-light); letter-spacing: 0.5px; }
        .barcode-wrap { opacity: 0.28; }
        .barcode-text { font-family: 'Libre Barcode 39', cursive; font-size: 15px; color: white; letter-spacing: -2px; }

        /* ===================== PRINT ===================== */
        .print-btn {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--deep); color: white; border: none;
            padding: 11px 28px; border-radius: 8px;
            font-family: 'Montserrat', sans-serif; font-size: 12px;
            font-weight: 600; letter-spacing: 1px; cursor: pointer;
            box-shadow: 0 8px 24px rgba(39,18,74,0.4); transition: all 0.2s ease;
        }
        .print-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 30px rgba(39,18,74,0.5); }
        .valid-note { font-size: 10px; color: rgba(39,18,74,0.45); letter-spacing: 0.3px; margin-top: 10px; }
    </style>
</head>
<body>
<div class="page-wrapper">

    <div class="card">
        <div class="watermark"><span class="watermark-text">TRAXFIT</span></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="gold-line"></div>

        {{-- Dot grid texture --}}
        <div class="dot-grid">
            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                <defs>
                    <pattern id="dotpat" x="0" y="0" width="9" height="9" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.2" fill="rgba(201,168,76,1)"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#dotpat)"/>
            </svg>
        </div>

        {{-- Corner bracket accents --}}
        <div class="corner-accent corner-tl">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 19 L1 1 L19 1" stroke="rgba(201,168,76,0.4)" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="corner-accent corner-br">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 1 L19 19 L1 19" stroke="rgba(201,168,76,0.4)" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
        </div>

        {{-- Header --}}
        <div class="card-header">
            <div class="gym-logo-area">
                <div class="gym-emblem">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/>
                    </svg>
                </div>
                <span class="gym-name">{{ $gymSettings->nama_gym ?? 'TRAXFIT' }}</span>
            </div>
            <span class="card-badge">Member Card</span>
        </div>

        <div class="header-divider"></div>

        {{-- Body --}}
        <div class="card-body">

            {{-- Avatar column --}}
            <div class="member-avatar-col">
                <div class="member-avatar">
                    <span class="avatar-initials">
                        {{ strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', trim($transaction->member->nama)), 0, 2)))) }}
                    </span>
                </div>
                <div class="avatar-line"></div>
            </div>

            <div class="v-divider"></div>

            {{-- Member info --}}
            <div class="member-info">
                <div>
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
                        <span>{{ Str::limit($transaction->member->alamat ?? 'Alamat tidak tersedia', 34) }}</span>
                    </div>
                </div>
            </div>

            <div class="v-divider"></div>

            {{-- Right: chip + package --}}
            <div class="card-right">
                <div class="chip"></div>
                <div class="package-pill">
                    <span class="pkg-label">Package</span>
                    <span class="pkg-value">{{ $transaction->member->package->nama_paket ?? ($transaction->data_tambahan['paket_membership']['nama'] ?? '-') }}</span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="card-footer">
            <div class="footer-left">
                <div class="footer-dot"></div>
                <span class="footer-valid-label">Valid Until&nbsp;</span>
                <span class="footer-valid-date">{{ \Carbon\Carbon::parse($transaction->member->tgl_expired)->format('d/m/Y') }}</span>
            </div>
            <div class="barcode-wrap">
                <span class="barcode-text">*{{ $transaction->member->kode_member }}*</span>
            </div>
        </div>
    </div>

    {{-- Print controls --}}
    <div class="no-print" style="text-align:center;">
        <button onclick="window.print()" class="print-btn">
            <i class="fas fa-print"></i>&nbsp; Cetak Kartu Member
        </button>
        <div class="valid-note">Berlaku hingga {{ \Carbon\Carbon::parse($transaction->member->tgl_expired)->format('d F Y') }}</div>
    </div>

</div>
</body>
</html>