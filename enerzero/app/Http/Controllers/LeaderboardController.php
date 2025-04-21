<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function showUserRank()
    {
        $ranked = [
            ['rank' => 1, 'name' => 'Aisyah', 'score' => 3000, 'avatar' => 'https://i.pravatar.cc/150?img=1'],
            ['rank' => 2, 'name' => 'Raka', 'score' => 2800, 'avatar' => 'https://i.pravatar.cc/150?img=2'],
            ['rank' => 3, 'name' => 'Zidan', 'score' => 2500, 'avatar' => 'https://i.pravatar.cc/150?img=3'],
            ['rank' => 4, 'name' => 'Nisa', 'score' => 2400, 'avatar' => 'https://i.pravatar.cc/150?img=4'],
            ['rank' => 5, 'name' => 'Bima', 'score' => 2300, 'avatar' => 'https://i.pravatar.cc/150?img=5'],
            ['rank' => 6, 'name' => 'Fahri', 'score' => 2200, 'avatar' => 'https://i.pravatar.cc/150?img=6'],
            ['rank' => 7, 'name' => 'Ari', 'score' => 2100, 'avatar' => 'https://i.pravatar.cc/150?img=7'],
            ['rank' => 8, 'name' => 'Tari', 'score' => 2000, 'avatar' => 'https://i.pravatar.cc/150?img=8'],
            ['rank' => 9, 'name' => 'Maya', 'score' => 1900, 'avatar' => 'https://i.pravatar.cc/150?img=9'],
            ['rank' => 10, 'name' => 'Yuli', 'score' => 1800, 'avatar' => 'https://i.pravatar.cc/150?img=10'],
            ['rank' => 11, 'name' => 'Rizky', 'score' => 1700, 'avatar' => 'https://i.pravatar.cc/150?img=11'],
            ['rank' => 12, 'name' => 'Chandra', 'score' => 1600, 'avatar' => 'https://i.pravatar.cc/150?img=12'],
            ['rank' => 13, 'name' => 'Mila', 'score' => 1500, 'avatar' => 'https://i.pravatar.cc/150?img=13'],
            ['rank' => 14, 'name' => 'Miko', 'score' => 1400, 'avatar' => 'https://i.pravatar.cc/150?img=14'],
            ['rank' => 15, 'name' => '[username]', 'score' => 1300, 'avatar' => 'https://i.pravatar.cc/150?img=15'],
        ];

        $userRank = collect($ranked)->firstWhere('name', '[username]');

        return view('leaderboard.index', compact('ranked', 'userRank'));
    }
}