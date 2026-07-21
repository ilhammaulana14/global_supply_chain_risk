<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Supply Chain Risk Intelligence</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col">

        <!-- Logo -->
        <div class="p-6 border-b border-slate-700">

            <h2 class="text-3xl font-bold">
                🌍 SCRI
            </h2>

            <p class="text-sm text-slate-300 mt-2">
                Supply Chain Risk Intelligence
            </p>

        </div>

        <!-- Menu -->
        <nav class="flex-1 p-4 space-y-2">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                📊 Dashboard
            </a>

            <!-- Countries -->
            <a href="{{ route('countries.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ request()->routeIs('countries.*') ? 'bg-blue-600' : '' }}">
                🌍 Countries
            </a>

            <!-- Country Comparison -->
            <a href="{{ route('comparison.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ request()->routeIs('comparison.*') ? 'bg-blue-600' : '' }}">
                ⚖️ Country Comparison
            </a>

            <!-- Weather -->
            <a href="{{ route('weather.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ request()->routeIs('weather.*') ? 'bg-blue-600' : '' }}">
                🌤 Weather
            </a>

            <!-- Ports -->
            <a href="{{ route('ports.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ request()->routeIs('ports.*') ? 'bg-blue-600' : '' }}">
                🚢 Ports
            </a>

            <!-- Economy -->
            <a href="{{ route('economy.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ request()->routeIs('economy.*') ? 'bg-blue-600' : '' }}">
                💰 Economy
            </a>

            <!-- News -->
            <a href="{{ route('news.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ request()->routeIs('news.*') ? 'bg-blue-600' : '' }}">
                📰 News
            </a>

            <!-- Risk Score -->
            <a href="{{ route('risk-scores.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ request()->routeIs('risk-scores.*') ? 'bg-blue-600' : '' }}">
                ⚠️ Risk Scores
            </a>

        </nav>

    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Header -->
        <header class="bg-white shadow-md px-8 py-5 flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    Global Supply Chain Risk Intelligence
                </h1>

                <p class="text-sm text-gray-500">
                    Monitor • Analyze • Compare Global Supply Chain Risk
                </p>
            </div>

            <div class="flex items-center gap-5">

                <span class="font-semibold text-slate-700">
                    👤 {{ Auth::user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
                        Logout
                    </button>

                </form>

            </div>

        </header>

        <!-- Content -->
        <main class="flex-1 p-8">

            <div class="max-w-7xl mx-auto">

                @if(session('success'))
                    <div class="mb-5 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-800">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </div>

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

</body>
</html>
