<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EducationService
{
    public function getEducations($page = 1, $perPage = 9): LengthAwarePaginator
    {
        $items = collect([
            [
                'id' => 1,
                'title' => 'Pengenalan Kendaraan Listrik di Indonesia',
                'content' => 'Video ini menjelaskan tentang perkembangan kendaraan listrik di Indonesia, termasuk infrastruktur pengisian daya dan kebijakan pemerintah terkait.',
                'category' => 'Video',
                'image' => 'https://img.youtube.com/vi/Ow880CGkRxA/maxresdefault.jpg',
                'video_id' => 'Ow880CGkRxA',
                'published_at' => now()
            ],
            [
                'id' => 2,
                'title' => 'Cara Mengisi Daya Kendaraan Listrik',
                'content' => 'Panduan lengkap tentang cara mengisi daya kendaraan listrik, termasuk jenis-jenis stasiun pengisian dan tips menghemat baterai.',
                'category' => 'Tips',
                'image' => 'https://img.youtube.com/vi/Ow880CGkRxA/maxresdefault.jpg',
                'video_id' => 'Ow880CGkRxA',
                'published_at' => now()
            ],
            [
                'id' => 3,
                'title' => 'Perbandingan Kendaraan Listrik vs Konvensional',
                'content' => 'Analisis mendalam tentang perbandingan kendaraan listrik dengan kendaraan konvensional dari segi biaya, performa, dan dampak lingkungan.',
                'category' => 'Edukasi',
                'image' => 'https://img.youtube.com/vi/Ow880CGkRxA/maxresdefault.jpg',
                'video_id' => 'Ow880CGkRxA',
                'published_at' => now()
            ]
        ]);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
} 