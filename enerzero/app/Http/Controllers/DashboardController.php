<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $username = 'User123';

        $simulationSummary = [
            ['label' => 'Good energy usage', 'color' => 'rgba(173, 237, 193, 0.7)'],
            ['label' => 'Bad energy usage', 'color' => 'rgba(141, 210, 152, 0.7)'],
            ['label' => 'Really bad energy usage', 'color' => 'rgba(230, 230, 230, 0.7)'],
            ['label' => 'Really good energy usage', 'color' => 'rgba(44, 132, 52, 0.7)'],
        ];

        $forums = Forum::withCount(['replies', 'likes'])
            ->latest()
            ->take(5)
            ->get();

        $products = Product::all();

        return view('dashboard', compact('username', 'simulationSummary', 'forums', 'products'));
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
