<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Mengambil semua notifikasi user yang sudah urut dari terbaru ke lama
    public function index()
    {
        $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->get();
        return response()->json($notifications);
    }

    // Tandai satu notifikasi sebagai sudah dibaca
    public function markAsRead(Request $request)
    {
        $id = $request->input('id');

        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'not_found'], 404);
    }

    // Tandai semua notifikasi yang belum dibaca sebagai sudah dibaca
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    }
}
