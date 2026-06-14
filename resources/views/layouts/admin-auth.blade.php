<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SmartGeoKAI Admin' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --kai-blue: #0d47a1;
            --kai-orange: #f57c00;
            --kai-green: #2e7d32;
            --kai-navy: #0f2744;
            --soft-bg: #eef5f1;
            --card-bg: rgba(255, 255, 255, 0.92);
            --text-main: #102235;
            --text-muted: #627286;
            --border-soft: rgba(15, 39, 68, 0.08);
            --input-bg: #f7fafc;
            --danger: #c62828;
            --success: #1b8f4d;
            --shadow-lg: 0 24px 60px rgba(12, 34, 58, 0.12);
            --shadow-sm: 0 10px 24px rgba(12, 34, 58, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(245, 124, 0, 0.12), transparent 28%),
                radial-gradient(circle at top right, rgba(13, 71, 161, 0.18), transparent 30%),
                linear-gradient(135deg, #edf5f1 0%, #e6f0eb 45%, #f5f8fb 100%);
            min-height: 100vh;
            color: var(--text-main);
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
        }

        .auth-left {
            position: relative;
            padding: 40px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .auth-left::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(140deg, rgba(13, 71, 161, 0.08), transparent 35%),
                linear-gradient(320deg, rgba(46, 125, 50, 0.08), transparent 40%);
            pointer-events: none;
        }

        .logo-bar {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-box {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 52px;
        }

        .logo-box img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        .logo-fallback {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.4px;
            color: var(--kai-navy);
        }

        .hero-copy {
            position: relative;
            z-index: 2;
            max-width: 620px;
            margin-top: 40px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,0.75);
            border: 1px solid rgba(15, 39, 68, 0.08);
            color: var(--kai-navy);
            font-size: 13px;
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }

        .hero-title {
            font-size: 48px;
            line-height: 1.08;
            margin: 18px 0 12px;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--kai-navy);
        }

        .hero-desc {
            font-size: 16px;
            line-height: 1.85;
            color: var(--text-muted);
            max-width: 580px;
        }

        .hero-stats {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 32px;
            max-width: 760px;
        }

        .hero-stat {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(15, 39, 68, 0.08);
            border-radius: 18px;
            padding: 18px 18px;
            box-shadow: var(--shadow-sm);
        }

        .hero-stat .label {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .hero-stat .value {
            font-size: 24px;
            font-weight: 800;
            color: var(--kai-navy);
        }

        .hero-footer {
            position: relative;
            z-index: 2;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 32px;
        }

        .auth-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 36px;
        }

        .auth-card {
            width: 100%;
            max-width: 520px;
            background: var(--card-bg);
            border: 1px solid rgba(255,255,255,0.6);
            backdrop-filter: blur(16px);
            border-radius: 28px;
            box-shadow: var(--shadow-lg);
            padding: 34px 32px;
            position: relative;
        }

        .auth-card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 28px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(13, 71, 161, 0.12), rgba(245, 124, 0, 0.12), rgba(46, 125, 50, 0.12));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 26px;
        }

        .auth-icon-wrap {
            width: 74px;
            height: 74px;
            margin: 0 auto 16px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(13, 71, 161, 0.12), rgba(46, 125, 50, 0.12));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 0 1px rgba(15,39,68,0.06);
        }

        .auth-title {
            margin: 0;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--kai-navy);
        }

        .auth-subtitle {
            margin-top: 8px;
            font-size: 14px;
            line-height: 1.7;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
            color: var(--kai-navy);
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #6f7f90;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            border: 1px solid var(--border-soft);
            background: var(--input-bg);
            border-radius: 16px;
            padding: 14px 16px 14px 46px;
            outline: none;
            font-size: 14px;
            font-family: inherit;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: rgba(13, 71, 161, 0.4);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.08);
        }

        .btn-primary {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 15px 18px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 800;
            font-family: inherit;
            color: white;
            background: linear-gradient(135deg, var(--kai-blue), #1663d1 55%, var(--kai-green));
            box-shadow: 0 14px 28px rgba(13, 71, 161, 0.18);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(13, 71, 161, 0.24);
        }

        .auth-link {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
        }

        .auth-link a {
            color: var(--kai-blue);
            font-weight: 800;
            text-decoration: none;
        }

        .alert-success,
        .alert-error {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.7;
        }

        .alert-success {
            background: rgba(27, 143, 77, 0.10);
            border: 1px solid rgba(27, 143, 77, 0.18);
            color: var(--success);
        }

        .alert-error {
            background: rgba(198, 40, 40, 0.08);
            border: 1px solid rgba(198, 40, 40, 0.14);
            color: var(--danger);
        }

        .error-list {
            margin: 0;
            padding-left: 18px;
        }

        .auth-note {
            margin-top: 14px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        @media (max-width: 1100px) {
            .auth-shell {
                grid-template-columns: 1fr;
            }

            .auth-left {
                padding-bottom: 0;
            }

            .auth-right {
                padding-top: 8px;
            }

            .hero-title {
                font-size: 38px;
            }
        }

        @media (max-width: 640px) {
            .auth-left,
            .auth-right {
                padding: 20px;
            }

            .hero-stats {
                grid-template-columns: 1fr;
            }

            .auth-card {
                padding: 26px 20px;
                border-radius: 24px;
            }

            .hero-title {
                font-size: 32px;
            }

            .logo-box img {
                height: 34px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-shell">
        <section class="auth-left">
            <div>
                <div class="logo-bar">
                    <div class="logo-box" style="justify-content:flex-end;">
                        @if(file_exists(public_path('images/logo-kai.png')))
                            <img src="{{ asset('images/logo-kai.png') }}" alt="KAI">
                        @else
                            <div class="logo-fallback">KAI</div>
                        @endif
                    </div>

                                        <div class="logo-box">
                        @if(file_exists(public_path('images/logo-danantara.png')))
                            <img src="{{ asset('images/logo-danantara.png') }}" alt="Danantara">
                        @else
                            <div class="logo-fallback">DANANTARA</div>
                        @endif
                    </div>
                </div>

                <div class="hero-copy">
                    <div class="hero-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L19 5V11C19 16 15.5 20.5 12 22C8.5 20.5 5 16 5 11V5L12 2Z" stroke="#0D47A1" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Sistem Monitoring Aset Tanah dan Bangunan PT KAI Daop 6 Yogyakarta
                    </div>

                    <h1 class="hero-title">SmartGeoKAI Admin Panel</h1>

                    <div class="hero-desc">
                        Platform pengelolaan aset geografis untuk mendukung monitoring, validasi wilayah,
                        pelaporan, dan pengendalian data petugas lapangan secara terstruktur PT KAI Daop 6 Yogyakarta.
                    </div>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="label">Integrasi Wilayah</div>
                            <div class="value">Provinsi → Kabupaten → Kecamatan</div>
                        </div>
                        <div class="hero-stat">
                            <div class="label">Pengelolaan Data</div>
                            <div class="value">User, Aset, Laporan</div>
                        </div>
                        <div class="hero-stat">
                            <div class="label">Statistik</div>
                            <div class="value">Tanah & Bangunan Aset</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-footer">
                SmartGeoKAI — PT KAI Daop 6 Yogyakarta
            </div>
        </section>

        <section class="auth-right">
            <div class="auth-card">
                @yield('content')
            </div>
        </section>
    </div>
</body>
</html>