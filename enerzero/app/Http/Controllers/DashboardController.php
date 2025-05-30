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
        $notifications = auth()->user()->notifications; // include read and unread

        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $notification = auth()->user()->notifications()->find($request->id);
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['status' => 'success', 'id' => $request->id]);
    }
}
