<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $forumPosts = [
            [
                'title' => 'Info buat hemat daya!',
                'content' => 'Gimana cara biar hemat daya nih, lagi banyak pemakaian, apa ada caranya? solanya laagi ada acara cuman takut boncos juga!',
                'icon' => 'flash',
                'time' => '1 day ago'
            ],
            [
                'title' => '3 Tips and trick buat usage daya yang oke',
                'content' => 'Nih 3 tips dari gw yang sering pake daya energi lumayan banyak, tetapi bisa tetep oke...',
                'icon' => 'lightbulb',
                'time' => '10 days ago'
            ],
            [
                'title' => 'Hemat energi pangkalan oke',
                'content' => 'Jadi tolong ges gimana menurut kalian tentang penghematan energi...',
                'icon' => 'flash',
                'time' => ''
            ]
        ];

        $recommendation = [
            'image' => '/images/lyumo-us.jpg', // you need to add this image in /public/images/
            'title' => 'LYUMO US 24KW Home Electricity Energy Factor Saver Electronic',
            'price' => 'Rp 250.000,-'
        ];

        return view('dashboard', compact('username', 'simulationSummary', 'forumPosts', 'recommendation'));
    }
}