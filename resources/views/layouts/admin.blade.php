<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SCRI — Admin Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        *{ font-family:'Inter',system-ui,sans-serif; }
        body{ background:#F0F2F5; }

        /* Sidebar */
        .sidebar{ background:#1A2332; min-height:100vh; width:240px; position:fixed; top:0; left:0; z-index:50; display:flex; flex-direction:column; }
        .sidebar-logo{ padding:28px 24px 20px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sidebar-logo h2{ color:#fff; font-size:20px; font-weight:800; letter-spacing:.5px; }
        .sidebar-logo p{ color:rgba(255,255,255,.4); font-size:11px; margin-top:2px; }
        .sidebar-nav{ flex:1; padding:16px 12px; overflow-y:auto; }
        .nav-item{ display:flex; align-items:center; gap:12px; padding:11px 16px; border-radius:10px; color:rgba(255,255,255,.55); font-size:13.5px; font-weight:600; text-decoration:none; margin-bottom:2px; transition:all .2s ease; }
        .nav-item:hover{ color:#fff; background:rgba(255,255,255,.07); }
        .nav-item.active{ color:#fff; background:#2D9F6F; box-shadow:0 4px 12px rgba(45,159,111,.35); }
        .nav-section{ padding:18px 16px 8px; font-size:10px; font-weight:700; color:rgba(255,255,255,.25); text-transform:uppercase; letter-spacing:1.5px; }
        .sidebar-bottom{ padding:12px; border-top:1px solid rgba(255,255,255,.08); }
        .sidebar-bottom .nav-item{ color:rgba(255,255,255,.4); font-size:12.5px; }

        /* Main */
        .main-wrap{ margin-left:240px; min-height:100vh; }
        .topbar{ background:#fff; border-bottom:1px solid #E8ECF0; padding:16px 32px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:40; }
        .topbar-left h1{ font-size:16px; font-weight:700; color:#1A2332; }
        .topbar-left p{ font-size:12px; color:#8B95A5; }
        .topbar-right{ display:flex; align-items:center; gap:16px; }
        .topbar-user{ font-size:13px; font-weight:700; color:#1A2332; }
        .content-area{ padding:28px 32px; }

        /* Cards */
        .card{ background:#fff; border-radius:14px; border:1px solid #E8ECF0; overflow:hidden; }
        .card-body{ padding:20px 24px; }

        /* Stat Cards */
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

        /* Search */
        .search-input{ background:#F4F5F7; border:1px solid #E8ECF0; border-radius:8px; padding:10px 14px; font-size:13px; outline:none; transition:border .2s; width:100%; }
        .search-input:focus{ border-color:#2D9F6F; }

        /* Progress bar */
        .progress-bar{ width:100%; background:#F0F2F5; border-radius:999px; height:8px; overflow:hidden; }
        .progress-fill{ height:100%; border-radius:999px; transition:width .5s ease; }

        /* Section */
        .section-title{ font-size:18px; font-weight:800; color:#1A2332; }
        .section-subtitle{ font-size:12px; color:#8B95A5; margin-top:2px; }

        /* Alerts */
        .alert{ padding:12px 20px; border-radius:10px; font-size:13px; font-weight:600; margin-bottom:16px; display:flex; align-items:center; gap:10px; }
        .alert-success{ background:#E8F5EF; color:#1B7A4A; border:1px solid #C3E6D4; }
        .alert-error{ background:#FDECEC; color:#C33B3B; border:1px solid #F5C6C6; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <h2>⚙ Admin Panel</h2>
        <p>Supply Chain Risk Intelligence</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            User Management
        </a>
        <a href="{{ route('admin.ports.index') }}" class="nav-item {{ request()->routeIs('admin.ports.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
            Port Dataset
        </a>
        <div class="nav-section">Navigation</div>
        <a href="{{ route('dashboard') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
            Back to App
        </a>
    </nav>
    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item" style="width:100%; border:none; background:none; cursor:pointer; text-align:left;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- Main -->
<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <h1>SCRI Admin Panel</h1>
            <p>Supply Chain Risk Intelligence — Administration</p>
        </div>
        <div class="topbar-right">
            <img class="topbar-avatar" style="width:36px;height:36px;border-radius:50%;border:2px solid #2D9F6F;" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=2D9F6F&color=fff&bold=true&size=72" alt="avatar">
            <span class="topbar-user">{{ Auth::user()->name ?? 'Admin' }}</span>
        </div>
    </header>

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
