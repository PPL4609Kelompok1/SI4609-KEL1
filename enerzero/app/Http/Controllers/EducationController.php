<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookmarkedContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EducationController extends Controller
{
    public function index()
    {
        $categories = [
            'Rumah',
            'Energi Terbarukan',
            'Transportasi',
            'Kantor',
            'Teknologi'
        ];

        $contents = [
            [
                'type' => 'article',
                'category' => 'Rumah',
                'title' => '7 Cara Menghemat Listrik di Rumah yang Perlu Anda Cermati',
                'description' => 'Pelajari cara-cara praktis untuk menghemat konsumsi listrik di rumah Anda dan mengurangi tagihan bulanan.',
                'thumbnail' => 'http://localhost:8000/images/hemat_rumah.jpg',
                'content' => 'https://www.cimbniaga.co.id/id/inspirasi/perencanaan/cara-menghemat-listrik-yang-perlu-anda-ketahui?utm_source=chatgpt.com'
            ],
            [
                'type' => 'video',
                'category' => 'Rumah',
                'title' => 'Catat! Ini 6 Cara Menghemat Tagihan Listrik di Rumah',
                'description' => 'Video berisi 6 cara praktis untuk menghemat tagihan listrik bulanan di rumah.',
                'thumbnail' => 'https://img.youtube.com/vi/4QOO93rEaT0/maxresdefault.jpg',
                'video_id' => '4QOO93rEaT0',
                'content' => 'https://www.youtube.com/embed/4QOO93rEaT0' // Embed URL for index page
            ],
            [
                'type' => 'article',
                'category' => 'Energi Terbarukan',
                'title' => 'Hemat Energi untuk Masa Depan: Sumber dan Manfaatnya',
                'description' => 'Artikel tentang pentingnya hemat energi, sumber, dan manfaatnya bagi masa depan.',
                'thumbnail' => 'http://localhost:8000/images/hemat_energi_terbarukan.jpg',
                'content' => 'https://www.rri.co.id/lain-lain/1062708/hemat-energi-untuk-masa-depan-sumber-dan-manfaatnya?utm_source=chatgpt.com'
            ],
             [
                'type' => 'video',
                'category' => 'Energi Terbarukan',
                'title' => 'Energi Terbarukan: Pengertian, Jenis, Dampak, dan Contohnya',
                'description' => 'Penjelasan komprehensif mengenai energi terbarukan, jenis-jenisnya, dampak, dan contoh aplikasinya.',
                'thumbnail' => 'https://img.youtube.com/vi/hG3km2fGgrM/maxresdefault.jpg',
                'video_id' => 'hG3km2fGgrM',
                'content' => 'https://www.youtube.com/embed/hG3km2fGgrM' // Embed URL for index page
            ],
            [
                'type' => 'article',
                'category' => 'Transportasi',
                'title' => 'Menhub: Mari Gunakan Transportasi Ramah Lingkungan Untuk Menghemat Energi',
                'description' => 'Pernyataan Menteri Perhubungan tentang pentingnya transportasi ramah lingkungan untuk efisiensi energi.',
                'thumbnail' => 'http://localhost:8000/images/hemat_transportasi.jpg',
                'content' => 'https://dephub.go.id/post/read/menhub-mari-gunakan-transportasi-ramah-lingkungan-untuk-menghemat-energi?utm_source=chatgpt.com'
            ],
             [
                'type' => 'video',
                'category' => 'Transportasi',
                'title' => 'LRT Sebagai Transportasi Umum Hemat Energi, Minim Emisi Gas Rumah Kaca',
                'description' => 'Pembahasan mengenai keunggulan LRT sebagai moda transportasi umum yang hemat energi dan ramah lingkungan.',
                'thumbnail' => 'https://img.youtube.com/vi/HehVc-fcQ2w/maxresdefault.jpg',
                'video_id' => 'HehVc-fcQ2w',
                'content' => 'https://www.youtube.com/embed/HehVc-fcQ2w' // Embed URL for index page
            ],
            [
                'type' => 'article',
                'category' => 'Kantor',
                'title' => 'Tips dan Trik Efisiensi Energi di Kantor, Simak Ulasannya!',
                'description' => 'Ulasan tentang tips dan trik praktis untuk meningkatkan efisiensi energi di lingkungan kantor.',
                'thumbnail' => 'http://localhost:8000/images/hemat_kantor.jpg',
                'content' => 'https://listrikindonesia.com/detail/12656/tips-dan-trik-efisiensi-energi-di-kantor-simak-ulasannya?utm_source=chatgpt.com'
            ],
             [
                'type' => 'video',
                'category' => 'Kantor',
                'title' => 'Tips Hemat Energi di Perkantoran',
                'description' => 'Tips praktis untuk menghemat energi saat bekerja di kantor.',
                'thumbnail' => 'https://img.youtube.com/vi/TNGgxT36iHs/maxresdefault.jpg',
                'video_id' => 'TNGgxT36iHs',
                'content' => 'https://www.youtube.com/embed/TNGgxT36iHs' // Embed URL for index page
            ],
            [
                'type' => 'article',
                'category' => 'Teknologi',
                'title' => 'Cara Menghemat Energi Listrik Menggunakan Teknologi Smart Home',
                'description' => 'Penjelasan mengenai pemanfaatan teknologi smart home untuk efisiensi penggunaan energi listrik.',
                'thumbnail' => 'http://localhost:8000/images/hemat_teknologi.jpg',
                'content' => 'https://lyrid.co.id/cara-menghemat-energi-listrik-menggunakan-teknologi-smart-home/?utm_source=chatgpt.com'
            ],
             [
                'type' => 'video',
                'category' => 'Teknologi',
                'title' => 'Teknologi Baru untuk Piala Dunia 2022: Pendingin Hemat Energi',
                'description' => 'Pembahasan teknologi pendingin hemat energi yang digunakan di Piala Dunia 2022.',
                'thumbnail' => 'https://img.youtube.com/vi/Lr9s_oHGwNY/maxresdefault.jpg',
                'video_id' => 'Lr9s_oHGwNY',
                'content' => 'https://www.youtube.com/embed/Lr9s_oHGwNY' // Embed URL for index page
            ]
        ];

        // Get user's bookmarked contents if logged in
        $bookmarkedContents = [];
        if (Auth::check()) {
            $bookmarkedContents = BookmarkedContent::where('user_id', Auth::id())
                ->pluck('content_url')
                ->toArray();
        }

        return view('Education.index', compact('categories', 'contents', 'bookmarkedContents'));
    }

    public function toggleBookmark(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $content = $request->validate([
                'type' => 'required|in:article,video',
                'title' => 'required|string',
                'category' => 'required|string',
                'description' => 'required|string',
                'thumbnail_url' => 'required|string',
                'content_url' => 'required|string',
                'video_id' => 'nullable|string'
            ]);

            // Use the content_url from the request, which will be the external link for articles or embed URL for videos
            // For bookmarking videos, we should probably store the watch URL instead of embed URL for consistency
            $bookmarkContentUrl = ($content['type'] === 'video') ? 'https://www.youtube.com/watch?v=' . $content['video_id'] : $content['content_url'];

            $bookmark = BookmarkedContent::where('user_id', Auth::id())
                ->where('content_url', $bookmarkContentUrl)
                ->first();

            if ($bookmark) {
                $bookmark->delete();
                return response()->json(['status' => 'removed']);
            }

            BookmarkedContent::create([
                'user_id' => Auth::id(),
                'content_type' => $content['type'],
                'title' => $content['title'],
                'category' => $content['category'],
                'description' => $content['description'],
                'thumbnail_url' => $content['thumbnail_url'],
                'content_url' => $bookmarkContentUrl
            ]);

            return response()->json(['status' => 'added']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            \Illuminate\Support\Facades\Log::error('Bookmark Validation Error:', ['errors' => $e->errors(), 'request' => $request->all()]);
             return response()->json(['message' => 'Validasi Gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Log any other exceptions
            \Illuminate\Support\Facades\Log::error('Bookmark Server Error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString(), 'request' => $request->all()]);
            return response()->json(['error' => 'Terjadi kesalahan di server: ' . $e->getMessage()], 500);
        }
    }

     public function show($category, $title)
    {
        // Dummy data for demonstration. In a real app, fetch from DB based on slugged title
        $contents = [
             [
                'type' => 'article',
                'category' => 'Rumah',
                'title' => '7 Cara Menghemat Listrik di Rumah yang Perlu Anda Cermati',
                'description' => 'Pelajari cara-cara praktis untuk menghemat konsumsi listrik di rumah Anda dan mengurangi tagihan bulanan.',
                'thumbnail' => 'http://localhost:8000/images/hemat_rumah.jpg',
                'content' => 'https://www.cimbniaga.co.id/id/inspirasi/perencanaan/cara-menghemat-listrik-yang-perlu-anda-ketahui?utm_source=chatgpt.com'
            ],
            [
                'type' => 'video',
                'category' => 'Rumah',
                'title' => 'Catat! Ini 6 Cara Menghemat Tagihan Listrik di Rumah',
                'description' => 'Video berisi 6 cara praktis untuk menghemat tagihan listrik bulanan di rumah.',
                'thumbnail' => 'https://img.youtube.com/vi/4QOO93rEaT0/maxresdefault.jpg',
                'video_id' => '4QOO93rEaT0',
                'content' => 'https://www.youtube.com/watch?v=4QOO93rEaT0' // Use watch URL for detail view
            ],
             [
                'type' => 'article',
                'category' => 'Energi Terbarukan',
                'title' => 'Hemat Energi untuk Masa Depan: Sumber dan Manfaatnya',
                'description' => 'Artikel tentang pentingnya hemat energi, sumber, dan manfaatnya bagi masa depan.',
                'thumbnail' => 'http://localhost:8000/images/hemat_energi_terbarukan.jpg',
                'content' => 'https://www.rri.co.id/lain-lain/1062708/hemat-energi-untuk-masa-depan-sumber-dan-manfaatnya?utm_source=chatgpt.com'
            ],
             [
                'type' => 'video',
                'category' => 'Energi Terbarukan',
                'title' => 'Energi Terbarukan: Pengertian, Jenis, Dampak, dan Contohnya',
                'description' => 'Penjelasan komprehensif mengenai energi terbarukan, jenis-jenisnya, dampak, dan contoh aplikasinya.',
                'thumbnail' => 'https://img.youtube.com/vi/hG3km2fGgrM/maxresdefault.jpg',
                'video_id' => 'hG3km2fGgrM',
                'content' => 'https://www.youtube.com/watch?v=hG3km2fGgrM' // Use watch URL for detail view
            ],
            [
                'type' => 'article',
                'category' => 'Transportasi',
                'title' => 'Menhub: Mari Gunakan Transportasi Ramah Lingkungan Untuk Menghemat Energi',
                'description' => 'Pernyataan Menteri Perhubungan tentang pentingnya transportasi ramah lingkungan untuk efisiensi energi.',
                'thumbnail' => 'http://localhost:8000/images/hemat_transportasi.jpg',
                'content' => 'https://dephub.go.id/post/read/menhub-mari-gunakan-transportasi-ramah-lingkungan-untuk-menghemat-energi?utm_source=chatgpt.com'
            ],
             [
                'type' => 'video',
                'category' => 'Transportasi',
                'title' => 'LRT Sebagai Transportasi Umum Hemat Energi, Minim Emisi Gas Rumah Kaca',
                'description' => 'Pembahasan mengenai keunggulan LRT sebagai moda transportasi umum yang hemat energi dan ramah lingkungan.',
                'thumbnail' => 'https://img.youtube.com/vi/HehVc-fcQ2w/maxresdefault.jpg',
                'video_id' => 'HehVc-fcQ2w',
                'content' => 'https://www.youtube.com/watch?v=HehVc-fcQ2w' // Use watch URL for detail view
            ],
            [
                'type' => 'article',
                'category' => 'Kantor',
                'title' => 'Tips dan Trik Efisiensi Energi di Kantor, Simak Ulasannya!',
                'description' => 'Ulasan tentang tips dan trik praktis untuk meningkatkan efisiensi energi di lingkungan kantor.',
                'thumbnail' => 'http://localhost:8000/images/hemat_kantor.jpg',
                'content' => 'https://listrikindonesia.com/detail/12656/tips-dan-trik-efisiensi-energi-di-kantor-simak-ulasannya?utm_source=chatgpt.com'
            ],
             [
                'type' => 'video',
                'category' => 'Kantor',
                'title' => 'Tips Hemat Energi di Perkantoran',
                'description' => 'Tips praktis untuk menghemat energi saat bekerja di kantor.',
                'thumbnail' => 'https://img.youtube.com/vi/TNGgxT36iHs/maxresdefault.jpg',
                'video_id' => 'TNGgxT36iHs',
                'content' => 'https://www.youtube.com/watch?v=TNGgxT36iHs' // Use watch URL for detail view
            ],
            [
                'type' => 'article',
                'category' => 'Teknologi',
                'title' => 'Cara Menghemat Energi Listrik Menggunakan Teknologi Smart Home',
                'description' => 'Penjelasan mengenai pemanfaatan teknologi smart home untuk efisiensi penggunaan energi listrik.',
                'thumbnail' => 'http://localhost:8000/images/hemat_teknologi.jpg',
                'content' => 'https://lyrid.co.id/cara-menghemat-energi-listrik-menggunakan-teknologi-smart-home/?utm_source=chatgpt.com'
            ],
             [
                'type' => 'video',
                'category' => 'Teknologi',
                'title' => 'Teknologi Baru untuk Piala Dunia 2022: Pendingin Hemat Energi',
                'description' => 'Pembahasan teknologi pendingin hemat energi yang digunakan di Piala Dunia 2022.',
                'thumbnail' => 'https://img.youtube.com/vi/Lr9s_oHGwNY/maxresdefault.jpg',
                'video_id' => 'Lr9s_oHGwNY',
                'content' => 'https://www.youtube.com/watch?v=Lr9s_oHGwNY' // Use watch URL for detail view
            ]
        ];

        // Find the content based on slugged category and title
        $foundContent = null;
        foreach ($contents as $content) {
            if (Str::slug($content['category']) === $category && Str::slug($content['title']) === $title) {
                $foundContent = $content;
                break;
            }
        }

        if (!$foundContent) {
            abort(404); // Content not found
        }

        // If it's an article, redirect to the external URL
        if ($foundContent['type'] === 'article') {
            return redirect()->away($foundContent['content']);
        }

        // If it's a video, show the detail view (optional, could also redirect to YouTube watch URL)
        return view('Education.show', compact('foundContent'));
    }

    public function bookmarked()
    {
        // Get bookmarked contents for the logged-in user
        $bookmarkedContents = BookmarkedContent::where('user_id', Auth::id())->get();

        // You might need to fetch full content details based on the bookmarked data
        // For now, let's pass the bookmarked data directly to the view

        return view('Education.bookmarked', compact('bookmarkedContents'));
    }
    
} 