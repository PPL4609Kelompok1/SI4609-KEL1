<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-png" href="{{ asset('Logo Enerzero.png') }}" />
    <title>@yield('title', 'Enerzero')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url("{{ asset('BackGround.png') }}");
            background-size: cover;
        }
        /* Scrollbar untuk forum */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.1);
            border-radius: 3px;
        }
        /* Sidebar active background */
        .sidebar-active {
            background-color: #a8e6cf;
            border-left: 4px solid #34a853;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-green-100 min-h-screen flex">
    <!-- Sidebar -->
    {{-- keep yang ini, scroll fixed gak ikut ke scroll --}}
    <aside class="w-56 bg-white shadow-lg fixed top-0 left-0 h-full">
        <div class="flex items-center gap-2 px-4 py-6 border-b border-gray-200">
            <a href="{{ url('/') }}" class="select-none">
                <img src="{{ asset('Logo Icon.png') }}" alt="Enerzero Icon" class="h-20 w-auto">
            </a>
        </div>
            <ul>
                <li>
                    <a href="/dashboard" class="flex items-center gap-3 px-6 py-3 {{ request()->is('dashboard') ? 'sidebar-active' : '' }} hover:bg-green-200">
                        <i class="fas fa-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 {{ request()->is('calculator') ? 'sidebar-active' : '' }} hover:bg-green-200">
                        <i class="fas fa-calculator"></i>
                        <span>Calculator</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 {{ request()->is('education') ? 'sidebar-active' : '' }} hover:bg-green-200">
                        <i class="fas fa-book-open"></i>
                        <span>Education</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('energy.index') }}" class="flex items-center gap-3 px-6 py-3 {{ request()->is('energy.index') ? 'sidebar-active' : '' }} hover:bg-green-200">
                        <i class="fas fa-chart-line"></i>
                        <span>Energy Usage Report</span>
                    </a>
                </li>
                <li>
                    <a href="/forum" class="flex items-center gap-3 px-6 py-3 {{ request()->is('forum') ? 'sidebar-active' : '' }} hover:bg-green-200">
                        <i class="fas fa-comments"></i>
                        <span>Forum</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-green-200 {{ request()->routeIs('products.index') ? 'sidebar-active text-green-700 font-semibold' : '' }}">
                        <i class="fas fa-solar-panel"></i>
                        <span>Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('maps.index') }}" class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('maps.*') ? 'sidebar-active text-green-700 font-semibold' : 'hover:bg-green-200' }}">
                        <i class="fas fa-map"></i>
                        <span>Map</span>
                    </a>
                </li>
                <li>
                    <a href="/leaderboard" class="flex items-center gap-3 px-6 py-3 {{ request()->is('leaderboard') ? 'sidebar-active' : '' }} hover:bg-green-200">
                        <i class="fas fa-stairs"></i>
                        <span>Leaderboard</span>
                    </a>
                </li>
                <li>
                    <a href="/mission" class="flex items-center gap-3 px-6 py-3 {{ request()->is('challenge') ? 'sidebar-active' : '' }} hover:bg-green-200">
                        <i class="fas fa-trophy"></i>
                        <span>Challenge</span>
                <li>
                    <a href="{{ route('energy.simulation.index') }}" class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('energy.simulation.*') ? 'sidebar-active' : '' }} hover:bg-green-200">
                        <i class="fas fa-bolt"></i>
                        <span>Simulasi Hemat Energi</span>
                    </a>
                </li>
            </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 relative overflow-auto ml-56">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
