<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function showUserRank($category = 'individu')
    {
        $dataSets = [
            'individu' => [
                ['rank' => 1, 'name' => 'Aisyah', 'score' => 3000, 'avatar' => 'https://i.pravatar.cc/150?img=1'],
                ['rank' => 2, 'name' => 'Raka', 'score' => 2800, 'avatar' => 'https://i.pravatar.cc/150?img=2'],
                ['rank' => 3, 'name' => 'Zidan', 'score' => 2500, 'avatar' => 'https://i.pravatar.cc/150?img=3'],
                ['rank' => 4, 'name' => 'Nisa', 'score' => 2400, 'avatar' => 'https://i.pravatar.cc/150?img=4'],
                ['rank' => 5, 'name' => 'Bima', 'score' => 2300, 'avatar' => 'https://i.pravatar.cc/150?img=5'],
                ['rank' => 6, 'name' => 'Fahri', 'score' => 2200, 'avatar' => 'https://i.pravatar.cc/150?img=6'],
                ['rank' => 7, 'name' => 'Ari', 'score' => 2100, 'avatar' => 'https://i.pravatar.cc/150?img=7'],
                ['rank' => 8, 'name' => auth()->user()->username, 'score' => 2000, 'avatar' => 'https://i.pravatar.cc/150?img=8'],
                ['rank' => 9, 'name' => 'Maya', 'score' => 1900, 'avatar' => 'https://i.pravatar.cc/150?img=9'],
                ['rank' => 10, 'name' => 'Yuli', 'score' => 1800, 'avatar' => 'https://i.pravatar.cc/150?img=10'],
                ['rank' => 11, 'name' => 'Rizky', 'score' => 1700, 'avatar' => 'https://i.pravatar.cc/150?img=11'],
                ['rank' => 12, 'name' => 'Chandra', 'score' => 1600, 'avatar' => 'https://i.pravatar.cc/150?img=12'],
                ['rank' => 13, 'name' => 'Mila', 'score' => 1500, 'avatar' => 'https://i.pravatar.cc/150?img=13'],
                ['rank' => 14, 'name' => 'Miko', 'score' => 1400, 'avatar' => 'https://i.pravatar.cc/150?img=14'],
                ['rank' => 15, 'name' => 'Tari', 'score' => 1300, 'avatar' => 'https://i.pravatar.cc/150?img=15'],
            ],

            'komunitas' => [
                ['rank' => 1, 'name' => 'Komunitas A', 'level' => 100, 'score' => 15000, 'avatar' => 'https://i.pravatar.cc/150?img=16'],
                ['rank' => 2, 'name' => 'Komunitas B', 'level' => 85, 'score' => 14500, 'avatar' => 'https://i.pravatar.cc/150?img=17'],
                ['rank' => 3, 'name' => 'Komunitas C', 'level' => 80, 'score' => 14000, 'avatar' => 'https://i.pravatar.cc/150?img=18'],
                ['rank' => 4, 'name' => '[Community]', 'level' => 75, 'score' => 13500, 'avatar' => 'https://i.pravatar.cc/150?img=19'],
                ['rank' => 5, 'name' => 'Komunitas E', 'level' => 70, 'score' => 13000, 'avatar' => 'https://i.pravatar.cc/150?img=20'],
                ['rank' => 6, 'name' => 'Komunitas F', 'level' => 65, 'score' => 12500, 'avatar' => 'https://i.pravatar.cc/150?img=21'],
                ['rank' => 7, 'name' => 'Komunitas G', 'level' => 64, 'score' => 12000, 'avatar' => 'https://i.pravatar.cc/150?img=22'],
                ['rank' => 8, 'name' => 'Komunitas H', 'level' => 63, 'score' => 11500, 'avatar' => 'https://i.pravatar.cc/150?img=23'],
                ['rank' => 9, 'name' => 'Komunitas I', 'level' => 60, 'score' => 11000, 'avatar' => 'https://i.pravatar.cc/150?img=24'],
                ['rank' => 10, 'name' => 'Komunitas J', 'level' => 58, 'score' => 10500, 'avatar' => 'https://i.pravatar.cc/150?img=25'],
                ['rank' => 11, 'name' => 'Komunitas K', 'level' => 56, 'score' => 10000, 'avatar' => 'https://i.pravatar.cc/150?img=26'],
                ['rank' => 12, 'name' => 'Komunitas L', 'level' => 55, 'score' => 9500, 'avatar' => 'https://i.pravatar.cc/150?img=27'],
                ['rank' => 13, 'name' => 'Komunitas M', 'level' => 52, 'score' => 9000, 'avatar' => 'https://i.pravatar.cc/150?img=28'],
                ['rank' => 14, 'name' => 'Komunitas N', 'level' => 50, 'score' => 8500, 'avatar' => 'https://i.pravatar.cc/150?img=29'],
                ['rank' => 15, 'name' => 'Komunitas O', 'level' => 48, 'score' => 8000, 'avatar' => 'https://i.pravatar.cc/150?img=30'],
            ],

            'wilayah' => [
                ['rank' => 1, 'name' => '[Region]', 'level' => 95, 'score' => 17000, 'avatar' => 'https://i.pravatar.cc/150?img=31'],
                ['rank' => 2, 'name' => 'DKI Jakarta', 'level' => 90, 'score' => 16500, 'avatar' => 'https://i.pravatar.cc/150?img=32'],
                ['rank' => 3, 'name' => 'Jawa Tengah', 'level' => 88, 'score' => 16000, 'avatar' => 'https://i.pravatar.cc/150?img=33'],
                ['rank' => 4, 'name' => 'Jawa Timur', 'level' => 85, 'score' => 15500, 'avatar' => 'https://i.pravatar.cc/150?img=34'],
                ['rank' => 5, 'name' => 'Sumatra Utara', 'level' => 80, 'score' => 15000, 'avatar' => 'https://i.pravatar.cc/150?img=35'],
                ['rank' => 6, 'name' => 'Bali', 'level' => 75, 'score' => 14500, 'avatar' => 'https://i.pravatar.cc/150?img=36'],
                ['rank' => 7, 'name' => 'Yogyakarta', 'level' => 70, 'score' => 14000, 'avatar' => 'https://i.pravatar.cc/150?img=37'],
                ['rank' => 8, 'name' => 'Papua', 'level' => 68, 'score' => 13500, 'avatar' => 'https://i.pravatar.cc/150?img=38'],
                ['rank' => 9, 'name' => 'Kalimantan', 'level' => 65, 'score' => 13000, 'avatar' => 'https://i.pravatar.cc/150?img=39'],
                ['rank' => 10, 'name' => 'Sulawesi', 'level' => 62, 'score' => 12500, 'avatar' => 'https://i.pravatar.cc/150?img=40'],
                ['rank' => 11, 'name' => 'Maluku', 'level' => 60, 'score' => 12000, 'avatar' => 'https://i.pravatar.cc/150?img=41'],
                ['rank' => 12, 'name' => 'Aceh', 'level' => 58, 'score' => 11500, 'avatar' => 'https://i.pravatar.cc/150?img=42'],
                ['rank' => 13, 'name' => 'NTB', 'level' => 55, 'score' => 11000, 'avatar' => 'https://i.pravatar.cc/150?img=43'],
                ['rank' => 14, 'name' => 'Nusa Tenggara Timur', 'level' => 50, 'score' => 10500, 'avatar' => 'https://i.pravatar.cc/150?img=44'],
                ['rank' => 15, 'name' => 'Maluku Utara', 'level' => 48, 'score' => 10000, 'avatar' => 'https://i.pravatar.cc/150?img=45'],
            ]
        ];

        if (!array_key_exists($category, $dataSets)) {
            return abort(404);
        }
        
        $ranked = $dataSets[$category];
        $userRank = collect($ranked)->firstWhere('name', auth()->user()->username);

        return view('leaderboard.index', compact('ranked', 'userRank', 'category'));
        // dd($userRank);
    }
}