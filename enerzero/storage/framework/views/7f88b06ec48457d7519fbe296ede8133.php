<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-png" href="<?php echo e(asset('Logo Enerzero.png')); ?>" />
    <title><?php echo $__env->yieldContent('title', 'Enerzero'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
   
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url("<?php echo e(asset('BackGround.png')); ?>");
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
    
    <aside class="w-56 bg-white shadow-lg fixed top-0 left-0 h-full">
        <div class="flex items-center gap-2 px-4 py-6 border-b border-gray-200">
            <a href="<?php echo e(url('/')); ?>" class="select-none">
                <img src="<?php echo e(asset('Logo Icon.png')); ?>" alt="Enerzero Icon" class="h-20 w-auto">
            </a>
        </div>
        <nav class="mt-6">
            <ul>
                <li>
                    <a href="/dashboard" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->is('dashboard') ? 'sidebar-active' : ''); ?> hover:bg-green-200">
                        <i class="fas fa-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->is('calculator') ? 'sidebar-active' : ''); ?> hover:bg-green-200">
                        <i class="fas fa-calculator"></i>
                        <span>Calculator</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->is('education') ? 'sidebar-active' : ''); ?> hover:bg-green-200">
                        <i class="fas fa-book-open"></i>
                        <span>Education</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('energy.index')); ?>" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->is('energy.index') ? 'sidebar-active' : ''); ?> hover:bg-green-200">
                        <i class="fas fa-chart-line"></i>
                        <span>Energy Usage Report</span>
                    </a>
                </li>
                <li>
                    <a href="/forum" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->is('forum') ? 'sidebar-active' : ''); ?> hover:bg-green-200">
                        <i class="fas fa-comments"></i>
                        <span>Forum</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('products.index')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-green-200 <?php echo e(request()->routeIs('products.index') ? 'sidebar-active text-green-700 font-semibold' : ''); ?>">
                        <i class="fas fa-solar-panel"></i>
                        <span>Produk</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('maps.index')); ?>" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->routeIs('maps.*') ? 'sidebar-active text-green-700 font-semibold' : 'hover:bg-green-200'); ?>">
                        <i class="fas fa-map"></i>
                        <span>Map</span>
                    </a>
                </li>
                <li>
                    <a href="/leaderboard" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->is('leaderboard') ? 'sidebar-active' : ''); ?> hover:bg-green-200">
                        <i class="fas fa-stairs"></i>
                        <span>Leaderboard</span>
                    </a>
                </li>
                <li>
                    <a href="/mission" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->is('challenge') ? 'sidebar-active' : ''); ?> hover:bg-green-200">
                        <i class="fas fa-trophy"></i>
                        <span>Challenge</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('energy.simulation.index')); ?>" class="flex items-center gap-3 px-6 py-3 <?php echo e(request()->routeIs('energy.simulation.*') ? 'sidebar-active' : ''); ?> hover:bg-green-200">
                        <i class="fas fa-bolt"></i>
                        <span>Simulasi Hemat Energi</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 relative overflow-auto ml-56">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\chris\OneDrive\Documents\SI4609-KEL1\enerzero\resources\views/layouts/app.blade.php ENDPATH**/ ?>