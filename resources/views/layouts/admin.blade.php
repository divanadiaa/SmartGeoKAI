<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin SmartGeoKAI' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @stack('styles')

    <style>
        :root {
            --kai-blue: #0d47a1;
            --kai-blue-soft: #e9f1ff;
            --kai-orange: #f57c00;
            --kai-orange-soft: #fff2e6;
            --kai-green: #2e7d32;
            --kai-green-soft: #e9f7ec;
            --kai-red: #d32f2f;
            --kai-red-soft: #fdecec;
            --kai-navy: #102235;
            --bg-main: #f4f7fb;
            --bg-card: #ffffff;
            --text-main: #102235;
            --text-muted: #6b7b8c;
            --border-soft: #e7edf5;
            --shadow-sm: 0 8px 22px rgba(16, 34, 53, 0.06);
            --shadow-md: 0 16px 34px rgba(16, 34, 53, 0.08);
            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-sm: 12px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(13, 71, 161, 0.05), transparent 24%),
                linear-gradient(180deg, #f7f9fc 0%, #f3f7fb 100%);
            color: var(--text-main);
        }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            padding: 22px 18px;
            background: linear-gradient(180deg, #0c2442 0%, #10355e 52%, #12467c 100%);
            color: #fff;
            box-shadow: 12px 0 28px rgba(16, 34, 53, 0.08);
            z-index: 20;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 30px;
        }

        .brand-badge {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255,255,255,0.16), rgba(255,255,255,0.06));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.10);
            flex-shrink: 0;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.4px;
            line-height: 1.1;
        }

        .brand-sub {
            font-size: 12px;
            color: rgba(255,255,255,0.75);
            margin-top: 4px;
        }

        .nav-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            color: rgba(255,255,255,0.48);
            margin: 18px 8px 10px;
            font-weight: 700;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 16px;
            margin-bottom: 8px;
            background: rgba(255,255,255,0.04);
            transition: all .18s ease;
        }

        .nav a:hover {
            background: rgba(255,255,255,0.10);
            transform: translateX(2px);
        }

        .nav a svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            position: absolute;
            left: 18px;
            right: 18px;
            bottom: 22px;
        }

        .logout-btn {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 13px 14px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, rgba(245,124,0,0.95), rgba(211,47,47,0.95));
            box-shadow: 0 12px 24px rgba(211, 47, 47, 0.16);
        }

        .main {
            margin-left: 280px;
            padding: 28px;
        }

        .topbar {
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.7);
            border-radius: 24px;
            padding: 18px 22px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .topbar h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.6px;
        }

        .topbar p {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .mini-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(13, 71, 161, 0.08), rgba(46, 125, 50, 0.08));
            color: var(--kai-navy);
            font-size: 13px;
            font-weight: 700;
            border: 1px solid rgba(13, 71, 161, 0.08);
            white-space: nowrap;
        }

        .brand-logo-top img {
            height: 34px;
            width: auto;
        }

        .page-section {
            margin-bottom: 22px;
        }

        .content-card,
        .card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 22px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(16,34,53,0.04);
        }

        .page-section > .content-card + .content-card,
        .page-section > .card + .card {
            margin-top: 18px;
        }

        .page-section div[style*="grid"] > .content-card,
        .page-section .grid-2 > .content-card,
        .page-section .grid > .content-card {
            margin-top: 0 !important;
        }

        .section-title {
            margin: 0 0 10px;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0 0 18px;
            line-height: 1.7;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1.3fr 0.7fr;
            gap: 18px;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            padding: 20px;
            border-radius: 22px;
            background: #fff;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(16,34,53,0.04);
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            right: -30px;
            top: -30px;
            background: rgba(13, 71, 161, 0.05);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .stat-value {
            font-size: 34px;
            font-weight: 800;
            color: var(--kai-navy);
            line-height: 1;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-blue { background: var(--kai-blue-soft); color: var(--kai-blue); }
        .icon-green { background: var(--kai-green-soft); color: var(--kai-green); }
        .icon-orange { background: var(--kai-orange-soft); color: var(--kai-orange); }
        .icon-red { background: var(--kai-red-soft); color: var(--kai-red); }

        .progress-group {
            display: grid;
            gap: 16px;
        }

        .progress-item .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-bottom: 8px;
            color: var(--text-muted);
            font-weight: 700;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            border-radius: 999px;
            background: #edf2f7;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            transition: width .35s ease;
        }

        .fill-green { background: linear-gradient(90deg, #2e7d32, #4caf50); }
        .fill-orange { background: linear-gradient(90deg, #f57c00, #ff9800); }
        .fill-red { background: linear-gradient(90deg, #d32f2f, #ef5350); }

        .toolbar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .form-inline {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            border: none;
            padding: 11px 16px;
            border-radius: 14px;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            font-weight: 800;
            transition: .18s ease;
        }

        .btn:hover { transform: translateY(-1px); }

        .btn-primary {
            color: white;
            background: linear-gradient(135deg, var(--kai-blue), #1565c0);
            box-shadow: 0 12px 22px rgba(13, 71, 161, 0.16);
        }

        .btn-success {
            color: white;
            background: linear-gradient(135deg, var(--kai-green), #43a047);
            box-shadow: 0 12px 22px rgba(27, 143, 77, 0.16);
        }

        .btn-secondary {
            color: var(--kai-navy);
            background: #eef3f8;
        }

        .btn-danger {
            color: white;
            background: linear-gradient(135deg, #d32f2f, #ef5350);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            margin-bottom: 2px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--kai-navy);
        }

        .form-control,
        .form-control-full,
        textarea,
        select,
        input[type="text"],
        input[type="number"],
        input[type="password"],
        input[type="file"] {
            border: 1px solid var(--border-soft);
            background: #f9fbfd;
            border-radius: 14px;
            padding: 12px 14px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-main);
            outline: none;
            transition: 0.2s ease;
        }

        .form-control { min-width: 190px; }
        .form-control-full { width: 100%; }

        .form-control:focus,
        .form-control-full:focus,
        textarea:focus,
        select:focus,
        input:focus {
            background: white;
            border-color: rgba(13, 71, 161, 0.35);
            box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.08);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .detail-item {
            background: #f8fbff;
            border: 1px solid #e8eef5;
            border-radius: 18px;
            padding: 16px;
        }

        .detail-label {
            font-size: 12px;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 15px;
            font-weight: 700;
            color: var(--kai-navy);
            line-height: 1.7;
            word-break: break-word;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        table th, table td {
            padding: 14px 16px;
            border-bottom: 1px solid #edf1f6;
            text-align: left;
            vertical-align: top;
            font-size: 14px;
        }

        table th {
            background: linear-gradient(180deg, #f8fbff 0%, #f1f6fb 100%);
            color: #3a4c61;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .badge-success { background: rgba(27,143,77,0.10); color: var(--kai-green); }
        .badge-warning { background: rgba(245,124,0,0.10); color: var(--kai-orange); }
        .badge-danger { background: rgba(211,47,47,0.10); color: var(--kai-red); }
        .badge-info { background: rgba(13,71,161,0.10); color: var(--kai-blue); }

        .image-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
            margin-top: 12px;
        }

        .image-card {
            background: #fff;
            border: 1px solid #e5ebf2;
            border-radius: 18px;
            padding: 10px;
        }

        .image-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 14px;
        }

        .muted {
            color: var(--text-muted);
            font-size: 13px;
        }

        .alert-error {
            background: rgba(211, 47, 47, 0.08);
            border: 1px solid rgba(211, 47, 47, 0.14);
            color: var(--kai-red);
            border-radius: 18px;
            padding: 16px;
        }

        .toast {
            position: fixed;
            right: 24px;
            top: 24px;
            min-width: 320px;
            max-width: 420px;
            z-index: 9999;
            border-radius: 18px;
            padding: 16px 18px;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: slideIn .25s ease;
            background: white;
        }

        .toast-success { border-left: 6px solid var(--kai-green); }
        .toast-error { border-left: 6px solid var(--kai-red); }

        .toast-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--kai-navy);
            margin-bottom: 3px;
        }

        .toast-message {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .icon-action {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s ease;
            padding: 0;
        }

        .icon-action i {
            font-size: 14px;
        }

        .icon-view {
            background: #eef2ff;
            color: #4f46e5;
        }

        .icon-edit {
            background: #ecfdf5;
            color: #16a34a;
        }

        .icon-delete {
            background: #fef2f2;
            color: #dc2626;
        }

        .icon-warning {
            background: #fff7ed;
            color: #ea580c;
        }

        .icon-success {
            background: #ecfdf5;
            color: #16a34a;
        }

        .icon-action:hover {
            transform: translateY(-1px);
            opacity: 0.9;
        }

        .form-error-text {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--kai-red);
            opacity: 0.9;
            letter-spacing: 0.2px;
        }

        .form-control-full.is-invalid {
            border-color: rgba(211, 47, 47, 0.6) !important;
            background: var(--kai-red-soft);
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.08);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px) translateX(10px); }
            to { opacity: 1; transform: translateY(0) translateX(0); }
        }

        @media (max-width: 1200px) {
            .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .grid-2 { grid-template-columns: 1fr; }
        }

        @media (max-width: 960px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }

            .sidebar-footer {
                position: static;
                margin-top: 18px;
            }

            .main {
                margin-left: 0;
                padding: 16px;
            }

            .form-grid,
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .topbar-right {
                justify-content: flex-start;
            }
        }

        @media (max-width: 640px) {
            .grid { grid-template-columns: 1fr; }
            .toast {
                left: 16px;
                right: 16px;
                min-width: auto;
            }
        }

        .custom-pagination-wrap nav {
            width: auto !important;
        }

        .custom-pagination-wrap nav > div:first-child {
            display: none !important;
        }

        .custom-pagination-wrap nav > div:last-child {
            display: flex !important;
            justify-content: flex-end !important;
        }

        .custom-pagination-wrap .relative.z-0.inline-flex {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            flex-wrap: wrap !important;
        }

        .custom-pagination-wrap a,
        .custom-pagination-wrap span {
            min-width: 40px !important;
            height: 40px !important;
            padding: 0 12px !important;
            border-radius: 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            font-size: 14px !important;
            line-height: 1 !important;
            border: 1px solid #dbe4ee !important;
            background: #eef3f8 !important;
            color: #102235 !important;
            box-sizing: border-box !important;
        }

        .custom-pagination-wrap a:hover {
            background: #e3ebf5 !important;
        }

        .custom-pagination-wrap span[aria-current="page"],
        .custom-pagination-wrap span[aria-current="page"] span {
            background: linear-gradient(135deg, #0d47a1, #1565c0) !important;
            color: #fff !important;
            border-color: #0d47a1 !important;
        }

        .custom-pagination-wrap span[aria-disabled="true"],
        .custom-pagination-wrap span[aria-disabled="true"] span {
            background: #f3f5f7 !important;
            color: #98a4b3 !important;
            border-color: #e4e9ef !important;
        }

        .custom-pagination-wrap svg {
            width: 16px !important;
            height: 16px !important;
        }

        .custom-pagination-wrap ul,
        .custom-pagination-wrap li {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="brand-area">
            <div class="brand-badge">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                    <path d="M12 21C15.5 17.8 19 14.1 19 10A7 7 0 1 0 5 10C5 14.1 8.5 17.8 12 21Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/>
                    <circle cx="12" cy="10" r="2.7" stroke="white" stroke-width="1.8"/>
                </svg>
            </div>
            <div>
                <div class="brand-title">SmartGeoKAI</div>
                <div class="brand-sub">Admin Sistem PT KAI Daop 6 Yogyakarta</div>
            </div>
        </div>

        <div class="nav-section-title">Navigasi Utama</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none"><path d="M4 10.5L12 4L20 10.5V20H4V10.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}">
                <svg viewBox="0 0 24 24" fill="none"><path d="M16 19C16 16.7909 14.2091 15 12 15H7C4.79086 15 3 16.7909 3 19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M9.5 11C11.433 11 13 9.433 13 7.5C13 5.567 11.433 4 9.5 4C7.567 4 6 5.567 6 7.5C6 9.433 7.567 11 9.5 11Z" stroke="currentColor" stroke-width="1.8"/></svg>
                Manajemen User
            </a>
            <a href="{{ route('admin.assets.index') }}">
                <svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5L12 4L20 7.5L12 11L4 7.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M4 12L12 15.5L20 12" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M4 16.5L12 20L20 16.5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
                Manajemen Aset
            </a>
            <a href="{{ route('admin.reports.index') }}">
                <svg viewBox="0 0 24 24" fill="none"><path d="M7 18V11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M12 18V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M17 18V13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M4 20H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Laporan Aset
            </a>
            <a href="{{ route('admin.reports.officers') }}">
                <svg viewBox="0 0 24 24" fill="none"><path d="M17 21V19C17 17.3431 15.6569 16 14 16H6C4.34315 16 3 17.3431 3 19V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M10 13C12.2091 13 14 11.2091 14 9C14 6.79086 12.2091 5 10 5C7.79086 5 6 6.79086 6 9C6 11.2091 7.79086 13 10 13Z" stroke="currentColor" stroke-width="1.8"/></svg>
                Laporan Petugas
            </a>
            <a href="{{ route('admin.reports.import.form') }}">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 3V15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M8 11L12 15L16 11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 17V19C4 20.1046 4.89543 21 6 21H18C19.1046 21 20 20.1046 20 19V17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                Import Data Aset
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>{{ $title ?? 'Dashboard' }}</h1>
                <p>Selamat datang, {{ auth()->user()->full_name }}. Kelola data SmartGeoKAI dengan aman dan terstruktur.</p>
            </div>

                <div class="brand-logo-top">
                    @if(file_exists(public_path('images/logo-kai.png')))
                        <img src="{{ asset('images/logo-kai.png') }}" alt="KAI">
                    @endif
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="toast toast-success" id="toast-message">
                <div style="color: var(--kai-green); margin-top:2px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M20 7L10 17L5 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <div class="toast-title">Berhasil</div>
                    <div class="toast-message">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast toast-error" id="toast-message">
                <div style="color: var(--kai-red); margin-top:2px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 8V12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                        <circle cx="12" cy="16" r="1" fill="currentColor"/>
                        <path d="M10.29 3.86L1.82 18A2 2 0 0 0 3.53 21H20.47A2 2 0 0 0 22.18 18L13.71 3.86A2 2 0 0 0 10.29 3.86Z" stroke="currentColor" stroke-width="1.8"/>
                    </svg>
                </div>
                <div>
                    <div class="toast-title">Gagal</div>
                    <div class="toast-message">{{ session('error') }}</div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        const toast = document.getElementById('toast-message');
        if (toast) {
            setTimeout(() => {
                toast.style.transition = 'all .25s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-8px)';
                setTimeout(() => toast.remove(), 260);
            }, 3200);
        }

        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.classList.contains('delete-form')) {
                const confirmed = confirm('Apakah yakin menghapus data ini?');
                if (!confirmed) e.preventDefault();
            }
        });

        const liveDatetime = document.getElementById('live-datetime');
        if (liveDatetime) {
            const dateLabel = liveDatetime.dataset.date;

            function updateClock() {
                const now = new Date();
                const hh = String(now.getHours()).padStart(2, '0');
                const mm = String(now.getMinutes()).padStart(2, '0');
                const ss = String(now.getSeconds()).padStart(2, '0');
                liveDatetime.textContent = `${dateLabel}, ${hh}:${mm}:${ss}`;
            }

            updateClock();
            setInterval(updateClock, 1000);
        }
    </script>

    @yield('scripts')
</body>
</html>