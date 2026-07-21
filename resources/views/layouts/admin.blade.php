<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>SCRI Admin Panel</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white">

        <div class="text-center py-6 border-b border-slate-700">

            <h1 class="text-3xl font-bold">
                SCRI
            </h1>

            <p class="text-gray-300">
                Admin Panel
            </p>

        </div>

        <nav class="mt-5">

            <a href="{{ route('admin.dashboard') }}"
               class="block px-6 py-3 hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">

                📊 Dashboard

            </a>

            <a href="{{ route('admin.users.index') }}"
               class="block px-6 py-3 hover:bg-slate-800 {{ request()->routeIs('admin.users.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">

                👥 User Management

            </a>

            <a href="{{ route('admin.ports.index') }}"
               class="block px-6 py-3 hover:bg-slate-800 {{ request()->routeIs('admin.ports.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">

                🚢 Port Dataset

            </a>

        </nav>

    </aside>

    <!-- Content -->
    <main class="flex-1">

        <header class="bg-white shadow px-8 py-5 flex justify-between items-center">

            <h2 class="text-2xl font-bold">

                Supply Chain Risk Intelligence

            </h2>

            <div class="flex items-center gap-5">

                <span class="font-medium">

                    {{ auth()->user()->name }}

                </span>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">

                        Logout

                    </button>

                </form>

            </div>

        </header>

        <div class="p-8">

            @yield('content')

        </div>

    </main>

</div>

</body>

</html>
