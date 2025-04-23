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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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
        }
    </style>
</head>
<body class="bg-green-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-56 bg-white shadow-lg">
        <div class="flex items-center gap-2 px-4 py-6 border-b border-gray-200">
            <a href="{{ url('/') }}" class="select-none">
                <img src="Logo Icon.png" alt="Enerzero Icon" class="h-20 w-auto">
            </a>
        </div>
        <nav class="mt-6">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-3 sidebar-active text-green-700 font-semibold">
                        <i class="fas fa-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-green-200">
                        <i class="fas fa-calculator"></i>
                        <span>Calculator</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-green-200">
                        <i class="fas fa-book-open"></i>
                        <span>Education</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-green-200">
                        <i class="fas fa-camera"></i>
                        <span>Simulation</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-green-200">
                        <i class="fas fa-comments"></i>
                        <span>Forum</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('index') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-green-200">
                        <i class="fas fa-bolt"></i>
                        <span>Analisis Energi</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-green-200">
                        <i class="fas fa-map"></i>
                        <span>Map</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 relative overflow-auto">
        @yield('content')
    </main>
</body>
</html>