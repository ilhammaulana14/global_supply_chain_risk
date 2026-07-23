<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SCRI — Global Supply Chain Risk Intelligence</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        *{ font-family:'Inter',system-ui,sans-serif; }
        body{ background:#F0F2F5; }

        /* Sidebar */
        .sidebar{ background:#1A2332; min-height:100vh; width:240px; position:fixed; top:0; left:0; z-index:50; display:flex; flex-direction:column; transition:all .3s ease; }
        .sidebar-logo{ padding:28px 24px 20px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sidebar-logo h2{ color:#fff; font-size:20px; font-weight:800; letter-spacing:.5px; }
        .sidebar-logo p{ color:rgba(255,255,255,.4); font-size:11px; margin-top:2px; }
        .sidebar-nav{ flex:1; padding:16px 12px; overflow-y:auto; }
        .sidebar-nav::-webkit-scrollbar{ width:4px; }
        .sidebar-nav::-webkit-scrollbar-thumb{ background:rgba(255,255,255,.1); border-radius:10px; }
        .nav-item{ display:flex; align-items:center; gap:12px; padding:11px 16px; border-radius:10px; color:rgba(255,255,255,.55); font-size:13.5px; font-weight:600; text-decoration:none; margin-bottom:2px; transition:all .2s ease; }
        .nav-item:hover{ color:#fff; background:rgba(255,255,255,.07); }
        .nav-item.active{ color:#fff; background:#2D9F6F; box-shadow:0 4px 12px rgba(45,159,111,.35); }
        .nav-item svg{ width:18px; height:18px; flex-shrink:0; }
        .nav-section{ padding:18px 16px 8px; font-size:10px; font-weight:700; color:rgba(255,255,255,.25); text-transform:uppercase; letter-spacing:1.5px; }
        .sidebar-bottom{ padding:12px; border-top:1px solid rgba(255,255,255,.08); }
        .sidebar-bottom .nav-item{ color:rgba(255,255,255,.4); font-size:12.5px; }

        /* Content Area */
        .main-wrap{ margin-left:240px; min-height:100vh; }

        /* Top Bar */
        .topbar{ background:#fff; border-bottom:1px solid #E8ECF0; padding:16px 32px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:40; }
        .topbar-left h1{ font-size:16px; font-weight:700; color:#1A2332; }
        .topbar-left p{ font-size:12px; color:#8B95A5; }
        .topbar-search{ position:relative; }
        .topbar-search input{ background:#F4F5F7; border:1px solid #E8ECF0; border-radius:8px; padding:8px 14px 8px 36px; font-size:13px; width:240px; outline:none; transition:border .2s; }
        .topbar-search input:focus{ border-color:#2D9F6F; }
        .topbar-search svg{ position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#8B95A5; width:16px; height:16px; }
        .topbar-right{ display:flex; align-items:center; gap:16px; }
        .topbar-avatar{ width:36px; height:36px; border-radius:50%; border:2px solid #2D9F6F; }
        .topbar-user{ font-size:13px; font-weight:700; color:#1A2332; }

        /* Content */
        .content-area{ padding:28px 32px; }

        /* Cards */
        .card{ background:#fff; border-radius:14px; border:1px solid #E8ECF0; overflow:hidden; }
        .card-body{ padding:20px 24px; }

        /* Stat Cards with colored top strip */
        .stat-card{ background:#fff; border-radius:14px; border:1px solid #E8ECF0; overflow:hidden; position:relative; }
        .stat-card::before{ content:''; position:absolute; top:0; left:0; right:0; height:4px; }
        .stat-card.green::before{ background:#2D9F6F; }
        .stat-card.amber::before{ background:#E5A030; }
        .stat-card.red::before{ background:#E04B4B; }
        .stat-card.blue::before{ background:#3B82F6; }
        .stat-card.indigo::before{ background:#6366F1; }
        .stat-card-body{ padding:20px 24px; }
        .stat-card-label{ font-size:12px; font-weight:600; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; }
        .stat-card-value{ font-size:28px; font-weight:800; color:#1A2332; margin-top:4px; line-height:1.2; }

        /* Tables */
        .data-table{ width:100%; border-collapse:collapse; }
        .data-table thead{ background:#F7F8FA; }
        .data-table th{ padding:12px 16px; font-size:11.5px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; text-align:left; border-bottom:1px solid #E8ECF0; }
        .data-table td{ padding:14px 16px; font-size:13.5px; color:#1A2332; border-bottom:1px solid #F0F2F5; vertical-align:middle; }
        .data-table tbody tr:hover{ background:#FAFBFC; }

        /* Badge */
        .badge{ display:inline-flex; align-items:center; padding:3px 10px; border-radius:6px; font-size:11.5px; font-weight:700; }
        .badge-green{ background:#E8F5EF; color:#1B7A4A; }
        .badge-amber{ background:#FEF3D9; color:#9A6A14; }
        .badge-red{ background:#FDECEC; color:#C33B3B; }
        .badge-blue{ background:#EBF2FF; color:#2563EB; }

        /* Buttons */
        .btn{ display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:8px; font-size:13px; font-weight:600; border:none; cursor:pointer; transition:all .2s; text-decoration:none; }
        .btn-primary{ background:#2D9F6F; color:#fff; }
        .btn-primary:hover{ background:#248A5E; box-shadow:0 4px 12px rgba(45,159,111,.3); }
        .btn-secondary{ background:#F4F5F7; color:#1A2332; border:1px solid #E8ECF0; }
        .btn-secondary:hover{ background:#E8ECF0; }
        .btn-danger{ background:#E04B4B; color:#fff; }
        .btn-danger:hover{ background:#C33B3B; }
        .btn-amber{ background:#E5A030; color:#fff; }
        .btn-amber:hover{ background:#C88C1C; }

        /* Search Input */
        .search-input{ background:#F4F5F7; border:1px solid #E8ECF0; border-radius:8px; padding:10px 14px; font-size:13px; outline:none; transition:border .2s; width:100%; }
        .search-input:focus{ border-color:#2D9F6F; }

        /* Progress bar */
        .progress-bar{ width:100%; background:#F0F2F5; border-radius:999px; height:8px; overflow:hidden; }
        .progress-fill{ height:100%; border-radius:999px; transition:width .5s ease; }

        /* Section Title */
        .section-title{ font-size:18px; font-weight:800; color:#1A2332; }
        .section-subtitle{ font-size:12px; color:#8B95A5; margin-top:2px; }

        /* Alerts */
        .alert{ padding:12px 20px; border-radius:10px; font-size:13px; font-weight:600; margin-bottom:16px; display:flex; align-items:center; gap:10px; }
        .alert-success{ background:#E8F5EF; color:#1B7A4A; border:1px solid #C3E6D4; }
        .alert-error{ background:#FDECEC; color:#C33B3B; border:1px solid #F5C6C6; }
    </style>
</head>

<body>

<!-- ==================== SIDEBAR ==================== -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <h2>🌍 SCRI</h2>
        <p>Supply Chain Risk Intelligence</p>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        <a href="{{ route('countries.index') }}" class="nav-item {{ request()->routeIs('countries.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0c0-1.1.9-2 2-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Countries
        </a>
        <a href="{{ route('comparison.index') }}" class="nav-item {{ request()->routeIs('comparison.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Comparison
        </a>
        <a href="{{ route('weather.index') }}" class="nav-item {{ request()->routeIs('weather.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-3-9.5 5.002 5.002 0 00-9 3.5z"></path></svg>
            Weather
        </a>
        <a href="{{ route('ports.index') }}" class="nav-item {{ request()->routeIs('ports.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
            Ports
        </a>
        <a href="{{ route('economy.index') }}" class="nav-item {{ request()->routeIs('economy.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Economy
        </a>
        <a href="{{ route('news.index') }}" class="nav-item {{ request()->routeIs('news.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            News
        </a>
        <a href="{{ route('risk-scores.index') }}" class="nav-item {{ request()->routeIs('risk-scores.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Risk Scores
        </a>

        @if(Auth::user() && Auth::user()->isAdmin())
        <div class="nav-section">Administration</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></circle></svg>
            Admin Panel
        </a>
        @endif
    </nav>

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item" style="width:100%; border:none; background:none; cursor:pointer; text-align:left;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- ==================== MAIN ==================== -->
<div class="main-wrap">

    <!-- Top Bar -->
    <header class="topbar">
        <div class="topbar-left">
            <h1>Global Supply Chain Risk Intelligence</h1>
            <p>Monitor • Analyze • Compare</p>
        </div>

        <div class="topbar-right">
            <form action="{{ route('countries.index') }}" method="GET" class="topbar-search">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
            </form>

            <img class="topbar-avatar" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=2D9F6F&color=fff&bold=true&size=72" alt="avatar">
            <span class="topbar-user">{{ Auth::user()->name ?? 'User' }}</span>
        </div>
    </header>

    <!-- Content -->
    <div class="content-area">

        @if(session('success'))
            <div class="alert alert-success">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')

</body>
</html>
