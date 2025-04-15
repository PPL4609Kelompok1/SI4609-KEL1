<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function showUserRank()
    {
        $ranked = [
            ['rank' => 1, 'name' => 'SHANKSAKAGAMI', 'score' => 12161, 'avatar' => 'https://i.pravatar.cc/150?img=1'],
            ['rank' => 2, 'name' => 'KEVANNN', 'score' => 12110, 'avatar' => 'https://i.pravatar.cc/150?img=2'],
            ['rank' => 3, 'name' => 'MANCCA', 'score' => 12104, 'avatar' => 'https://i.pravatar.cc/150?img=3'],
            ['rank' => 4, 'name' => 'CHUBA', 'score' => 11855, 'avatar' => 'https://i.pravatar.cc/150?img=4'],
            ['rank' => 5, 'name' => 'NANDI', 'score' => 11780, 'avatar' => 'https://i.pravatar.cc/150?img=5'],
            ['rank' => 6, 'name' => 'LUKA', 'score' => 11720, 'avatar' => 'https://i.pravatar.cc/150?img=6'],
            ['rank' => 7, 'name' => 'FARHAN', 'score' => 11688, 'avatar' => 'https://i.pravatar.cc/150?img=7'],
            ['rank' => 8, 'name' => 'SALMA', 'score' => 11650, 'avatar' => 'https://i.pravatar.cc/150?img=8'],
            ['rank' => 9, 'name' => 'ARIEL', 'score' => 11580, 'avatar' => 'https://i.pravatar.cc/150?img=9'],
            ['rank' => 10, 'name' => 'FIRMAN', 'score' => 11560, 'avatar' => 'https://i.pravatar.cc/150?img=10'],
            ['rank' => 11, 'name' => 'RAISYA', 'score' => 11490, 'avatar' => 'https://i.pravatar.cc/150?img=11'],
            ['rank' => 12, 'name' => 'BINTANG', 'score' => 11400, 'avatar' => 'https://i.pravatar.cc/150?img=12'],
            ['rank' => 13, 'name' => 'ALYA', 'score' => 11350, 'avatar' => 'https://i.pravatar.cc/150?img=13'],
            ['rank' => 14, 'name' => 'NABIL', 'score' => 11300, 'avatar' => 'https://i.pravatar.cc/150?img=14'],
            ['rank' => 15, 'name' => '[username]', 'score' => 11250, 'avatar' => 'https://i.pravatar.cc/150?img=15'],
        ];

        $userRank = collect($ranked)->firstWhere('name', '[username]');

        return view('leaderboard.index', compact('ranked', 'userRank'));
    }
}