<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{
    public function run()
    {
        $articles = [
            [
                'title' => 'Pengenalan Kendaraan Listrik',
                'content' => 'Kendaraan listrik (EV) adalah kendaraan yang menggunakan satu atau lebih motor listrik untuk penggerak. Tidak seperti kendaraan konvensional yang menggunakan mesin pembakaran dalam, kendaraan listrik menggunakan energi listrik yang disimpan dalam baterai atau perangkat penyimpanan energi lainnya.',
                'category' => 'Teknologi',
            ],
            [
                'title' => 'Tips Merawat Baterai EV',
                'content' => 'Merawat baterai kendaraan listrik sangat penting untuk memastikan umur panjang dan performa optimal. Berikut beberapa tips penting:\n\n1. Hindari pengisian hingga 100% secara rutin\n2. Jaga suhu baterai dalam kisaran optimal\n3. Hindari pengosongan baterai hingga 0%\n4. Gunakan pengisi daya yang direkomendasikan',
                'category' => 'Tips & Trik',
            ],
            [
                'title' => 'Perkembangan Infrastruktur Charging Station',
                'content' => 'Perkembangan infrastruktur charging station di Indonesia terus meningkat. Pemerintah telah menetapkan target untuk membangun ribuan stasiun pengisian daya di seluruh Indonesia dalam beberapa tahun ke depan.',
                'category' => 'Berita',
            ],
            [
                'title' => 'Panduan Mengisi Daya EV',
                'content' => 'Mengisi daya kendaraan listrik tidak sesulit yang dibayangkan. Berikut panduan lengkap:\n\n1. Cari charging station terdekat\n2. Siapkan aplikasi atau kartu pembayaran\n3. Hubungkan kabel pengisi daya\n4. Tunggu hingga pengisian selesai\n5. Lepaskan kabel dan simpan dengan rapi',
                'category' => 'Panduan',
            ],
        ];

        foreach ($articles as $article) {
            Education::create($article);
        }
    }
} 