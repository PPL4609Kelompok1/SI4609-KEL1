@extends('layouts.app')

@section('title', 'Enerzero')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <header class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-desktop text-2xl text-green-700"></i>
            <h1 class="text-3xl font-bold text-green-900">Dashboard</h1>
        </div>
        <div class="flex items-center gap-4 text-gray-600">
            <button title="Notifications" class="hover:text-green-700"><i class="fas fa-bell fa-lg"></i></button>
            <button title="Settings" class="hover:text-green-700"><i class="fas fa-cog fa-lg"></i></button>
            <div class="w-10 h-10 rounded-full bg-gray-300"></div>
        </div>
    </header>

    <!-- Welcome Text -->
    <section>
        <p class="text-lg font-semibold text-gray-900">
            Hai! Selamat datang di Enerzero <span class="font-mono">[{{ auth()->user()->name ?? 'username' }}]</span>
        </p>
        <p class="text-sm text-gray-800">Save Energy, Save the world!</p>
    </section>

    <!-- Main Cards Wrapper -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Simulation Data Summary --->
        <article class="col-span-2 bg-white rounded-lg p-6 shadow-md">
            <h2 class="text-green-700 font-semibold text-lg mb-4">SIMULATION DATA SUMMARY</h2>
            <div class="flex gap-6">
                <!-- Pie Chart and Legend -->
                <div class="flex-1 flex gap-4">
                    <div class="w-[150px] h-[150px]">
                        <!-- Placeholder Pie Chart with SVG -->
                        <svg viewBox="0 0 36 36" class="w-full h-full">
                            <circle r="16" cx="18" cy="18" fill="#c6f6d5" />
                            <circle r="16" cx="18" cy="18" fill="#34a853" stroke="#2f855a" stroke-width="5" stroke-dasharray="20 80" stroke-dashoffset="25" transform="rotate(-90 18 18)" />
                            <circle r="16" cx="18" cy="18" fill="none" stroke="#a0aec0" stroke-width="5" stroke-dasharray="35 65" stroke-dashoffset="45" transform="rotate(45 18 18)" />
                            <circle r="16" cx="18" cy="18" fill="none" stroke="#9ae6b4" stroke-width="5" stroke-dasharray="30 70" stroke-dashoffset="75" transform="rotate(180 18 18)" />
                        </svg>
                    </div>
                    <ul class="text-gray-700 text-sm space-y-2 self-center">
                        <li class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-200 block"></span> Good energy usage
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-400 block"></span> Bad energy usage
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-600 block"></span> Really bad energy usage
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-800 block"></span> Really good energy usage
                        </li>
                    </ul>
                </div>
            </div>

            <p class="mt-4 text-gray-800 text-sm">
                Hebat! dari data yang kami dapat, kami mengetahui bahwa kamu peka terhadap energi disekitar kamu.
                Semoga ini bisa terus berlangsung dan menjadi lebih baik. Kedepannya coba matikan hal...
            </p>

            <button class="mt-4 bg-yellow-400 text-black px-4 py-2 rounded font-semibold hover:bg-yellow-300">
                See Detail
            </button>
        </article>

        <!-- Education Card -->
        <article class="bg-white rounded-lg p-6 shadow-md flex flex-col md:flex-row md:items-center md:gap-6">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=300&q=80" alt="Solar Panels" class="rounded-lg w-full md:w-1/2 object-cover mb-4 md:mb-0" />
            <div class="flex-1">
                <h2 class="text-green-700 font-semibold text-lg mb-2 uppercase">Education</h2>
                <p class="font-bold text-black">
                    Dari Kesadaran Menuju Tindakan: Edukasi Energi sebagai Pendorong Pembangunan Berkelanjutan
                </p>
                <p class="text-gray-800 text-sm my-2">
                    Edukasi energi mencakup berbagai inisiatif yang ditujukan untuk menumbuhkan kesadaran, pemahaman, dan perilaku yang bertanggung jawab terhadapi...
                </p>
                <button class="mt-2 bg-yellow-400 text-black px-4 py-2 rounded font-semibold hover:bg-yellow-300">
                    Read More
                </button>
            </div>
        </article>

    </section>

    <!-- Bottom Section -->
    <section class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- Forum -->
        <article class="md:col-span-3 bg-white rounded-lg p-4 shadow-md overflow-auto max-h-[320px] scrollbar-thin">
            <h3 class="text-green-700 font-semibold text-lg mb-4">FORUM</h3>

            <div class="space-y-4">
                <!-- Post 1 -->
                <article class="bg-gray-200 p-3 rounded">
                    <h4 class="font-semibold">
                        <i class="fas fa-bolt mr-2"></i>
                        Info buat hemat daya!
                    </h4>
                    <p class="text-gray-700 text-sm">
                        Gimana cara biar hemat daya nih, lagi banyak pemakaian, apa ada caranya? solanya laagi ada acara cuman takut boncos juga!
                    </p>
                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        <i class="far fa-clock"></i>
                        1 day ago
                    </div>
                </article>

                <!-- Post 2 -->
                <article class="bg-gray-200 p-3 rounded">
                    <h4 class="font-semibold">
                        <i class="fas fa-lightbulb mr-2"></i>
                        3 Tips and trick buat usage daya yang oke
                    </h4>
                    <p class="text-gray-700 text-sm">
                        Nih 3 tips dari gw yang sering pake daya energi lumayan banyak, tetapi bisa tetep oke, jadi tips pertama dari gue itu ini, kalo siang usahain jangan pake lampu, karenakan lu pada udah...
                    </p>
                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        <i class="far fa-clock"></i>
                        10 days ago
                    </div>
                </article>

                <!-- Post 3 -->
                <article class="bg-gray-200 p-3 rounded">
                    <h4 class="font-semibold">
                        <i class="fas fa-bolt mr-2"></i>
                        Hemat energi pangkalan oke
                    </h4>
                    <p class="text-gray-700 text-sm">
                        Jadi tolong ges gimana menurut kalian tentang penghematan energi untuk kehidupan masa depan kalian masih masing, yang kalian tau kan juga banyak kejadian nih tentang energi, ban...
                    </p>
                </article>
            </div>
        </article>

        <!-- Recommendation -->
        <aside class="bg-white rounded-lg p-4 shadow-md">
            <h3 class="text-green-700 font-semibold text-lg mb-4 uppercase">RECOMENDATION</h3>
            <img src="https://cdn.shopify.com/s/files/1/0262/2646/7839/products/lyumo__ez_1_500x.png" alt="Product" class="mb-4 mx-auto max-w-[150px]" />
            <div class="text-center text-sm text-gray-700">
                <p class="font-bold">LYUMO US</p>
                <p>24KW Home Electricity</p>
                <p>Energy Factor Saver Electronic</p>
                <p class="mt-2">Price <br> <span class="font-bold text-lg">Rp 250.000,-</span></p>
            </div>
            <button class="mt-4 bg-yellow-400 text-black w-full py-2 rounded font-semibold hover:bg-yellow-300">
                See Product Detail
            </button>
        </aside>

    </section>

</div>
@endsection