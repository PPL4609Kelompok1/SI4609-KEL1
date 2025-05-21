<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Product;

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

        $forums = Forum::withCount(['replies', 'likes'])
        ->latest()
        ->take(5)
        ->get();

        $products = Product::all();

        $notification = [
            'type' => 'warning',
            'message' => 'Pola konsumsi energi kamu menunjukkan tren yang kurang baik. Coba evaluasi penggunaan listrik harianmu.'
        ];

        return view('dashboard', compact('username', 'simulationSummary', 'forums', 'products', 'notification'));
    }
}