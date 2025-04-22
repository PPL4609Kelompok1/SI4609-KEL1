
<?php $__env->startSection('title', 'Enerzero | Forum'); ?>

<!-- Main Content -->
<?php $__env->startSection('content'); ?>
    <!-- Box for forum content -->
    <div class="w-90/100 p-2">

        <!-- Forum Heading -->
        <div class="flex items-center mb-4">
            <i class="fas fa-comments text-green-600 text-xl mr-3"></i>
            <h1 class="text-2xl font-bold text-green-800">Forum</h1>
        </div>

        <!-- Search bar -->
        <div class="bg-green-300 w-1/4 p-3 mb-5 rounded-lg">
            <div class="flex item-center gap-4">
                <!-- Icon search -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                </svg>
                <!-- Input user to search forum by title -->
                <input type="text" placeholder="Type here to search" class="bg-transparent outline-none text-black" />
            </div>
        </div>

        <!-- Forum input card -->
        <div class="bg-white p-4 rounded-lg mb-4" id="forumBox">
            <h1 class="font-bold text-xl mb-2"> Create New forum</h1>
            <div class="flex items-center mb-4">
                <div class="flex-1">
                    <!-- Input title -->
                    <input 
                        type="text" 
                        placeholder="Add New Forum | Create Title"
                        class="bg-transparent outline-none text-black w-full"
                        id="titleInput"
                        onfocus="showDescription()"/>
                </div>
                <img alt="Add icon" class="ml-2 w-10 h-10" src="https://img.icons8.com/ios-filled/50/plus-math.png" />
            </div>
            <!-- Hidden form section -->
            <div id="descForm" class="hidden transition-all duration-300">
                <textarea id="descInput" placeholder="Enter description..." class="w-full p-2 border rounded mb-2"></textarea>
                <button class="bg-green-500 text-white px-4 py-2 rounded">Post</button>
            </div>
        </div>

        <script>
            const forumBox = document.getElementById("forumBox");
            const descForm = document.getElementById("descForm");

            function showDescription() {
                descForm.classList.remove("hidden");
            }

            document.addEventListener("click", function(event) {
                // Cek apakah klik di luar kotak
                if (!forumBox.contains(event.target)) {
                    descForm.classList.add("hidden");
                }
            });
        </script>

        <!-- Add Separator -->
        <div class="bg-white h-1 rounded-lg mb-4"></div>


        <!-- box for forum 1 -->
        <div class="bg-white p-4 rounded-lg mb-4 shadow">
            <!-- Judul forum dari user yang berada di DB -->
            <h2 class="text-xl font-bold mb-2">
                3 Tips and Tricks Menghemat Energi
            </h2>
            <div class="flex items-center mb-4">
                <img alt="User avatar" class="rounded-full mr-2" src="https://placehold.co/40x40" />
                <div>
                    <!-- Nama user -->
                    <!-- Auto generate from username -->
                    <p class="text-gray-900 font-semibold">
                        Mas Agus Indihome
                    </p>
                    <!-- Waktu posting -->
                    <!-- Auto generate from user timezone -->
                    <p class="text-gray-500 text-xs">
                        5 Hours ago
                    </p>
                </div>
            </div>      
            <!-- Review dari isi forum -->
            <p class="text-gray-700 mb-4">
                Dari yang kita tau, belakangan ini lagi ada banyak isu tentang energi yang kita pakai belakangan ini akan
                menghilang, atau akan punah... Aku punya 3 Tips dan Trik buat ngehemat dalam menggunakan energi, sehingga energi
                ini dapat kita pakai lebih lama lagi. Ini caranya :
                1. Matikan lampu yang tidak dipakai
                2. Coba lebih sering..
            </p>
            <div class="bg-yellow-400 h-10 w-1/6 rounded-lg flex justify-center items-center">
                <p class="text-black font-medium">Read More</p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chris\OneDrive\Documents\SI4609-KEL1\enerzero\resources\views/forum/forum.blade.php ENDPATH**/ ?>