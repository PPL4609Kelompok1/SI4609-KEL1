<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;


class DashboardController extends Controller
{
    public function index()
    {
        // Dummy Data, you can replace this with DB queries
        $username = 'User123';

        $simulationSummary = [
            ['label' => 'Good energy usage', 'color' => 'rgba(173, 237, 193, 0.7)'],
            ['label' => 'Bad energy usage', 'color' => 'rgba(141, 210, 152, 0.7)'],
            ['label' => 'Really bad energy usage', 'color' => 'rgba(230, 230, 230, 0.7)'],
            ['label' => 'Really good energy usage', 'color' => 'rgba(44, 132, 52, 0.7)'],
        ];

        $topForums = Forum::withCount('likes')->orderBy('likes_count', 'desc')->take(3)->get();
        return view('dashboard', compact('topForums'));

        $recommendation = [
            'image' => '/images/lyumo-us.jpg', // you need to add this image in /public/images/
            'title' => 'LYUMO US 24KW Home Electricity Energy Factor Saver Electronic',
            'price' => 'Rp 250.000,-'
        ];

        return view('dashboard', compact('username', 'simulationSummary', 'forumPosts', 'recommendation'));
    }
}