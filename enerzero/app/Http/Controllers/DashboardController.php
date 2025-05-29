<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Forum;
use App\Models\Product;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $username = Auth::user()->username;

        // Ambil semua report usage
        $reports = Report::all();

        // Ambil 2 data terakhir untuk perbandingan
        $latest = $reports->sortByDesc('id')->take(2);
        $current = $latest->first()->usage ?? 0;
        $previous = $latest->skip(1)->first()->usage ?? 0;

        $percentageChange = $previous ? number_format((($current - $previous) / $previous) * 100, 2) : 0;
        $trend = $current >= $previous ? 'increase' : 'decrease';
        
        $comparisonData = [
            'current_month' => $current,
            'previous_month' => $previous,
            'percentage_change' => $percentageChange,
            'trend' => $trend
        ];

        $forums = Forum::withCount(['replies', 'likes'])
        ->latest()
        ->take(5)
        ->get();

        $products = Product::all();

        $notification = [
            'type' => 'warning',
            'message' => 'Pola konsumsi energi kamu menunjukkan tren yang kurang baik. Coba evaluasi penggunaan listrik harianmu.'
        ];

        return view('dashboard', compact('username', 'reports', 'comparisonData', 'forums', 'products', 'notification'));

    }
  
    public function getNotifications()
    {
        $notifications = [
            [
                'id' => 1,
                'data' => ['message' => 'Penggunaan energi kamu melebihi batas normal! Segera lakukan penghematan.'],
                'read_at' => null,
                'type' => 'energy_alert'
            ],
            [
                'id' => 2,
                'data' => ['message' => 'Jangan lupa ikuti misi harian hari ini untuk mendapatkan poin tambahan!'],
                'read_at' => null,
                'type' => 'daily_challenge'
            ],
            [
                'id' => 3,
                'data' => ['message' => 'Artikel baru telah terbit: "Cara Cerdas Menghemat Energi di Rumah". Yuk baca sekarang!'],
                'read_at' => null,
                'type' => 'new_article'
            ],
        ];

        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $id = $request->input('id');
        return response()->json(['status' => 'success', 'id' => $id]);
    }
}
}
