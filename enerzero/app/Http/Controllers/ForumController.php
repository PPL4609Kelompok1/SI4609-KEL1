<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ForumReply;
use App\Models\ForumLike;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    
    // Menampilkan semua forum
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            $forums = Forum::where('title', 'LIKE', "%$query%")->get();
        } else {
            $forums = Forum::all();
        }

        return view('forum.forum', compact('forums'));
    }

    // Menyimpan forum baru
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Forum::create([
            'title' => $request->title,
            'description' => $request->description,
            'username' => $user->username,
        ]);

        return redirect()->route('forum')->with('success', 'Forum berhasil dibuat!');
    }

    public function show($id)
    {
        $forum = Forum::findOrFail($id);
        return view('forum.show', compact('forum'));
    }


    // Menampilkan form edit
    public function edit($id)
    {
        $forum = Forum::findOrFail($id);
        // cek user access
        if ($forum->username !== Auth::user()->username) {
            return back()->with('error', 'Kamu tidak memiliki izin untuk mengakses aksi ini.');
        }
        
        return view('forum.edit', compact('forum'));
    }

    // Update data forum
    public function update(Request $request, $id)
    {
        $forum = Forum::findOrFail($id);
        // cek user access
        if ($forum->username !== Auth::user()->username) {
            return back()->with('error', 'Kamu tidak memiliki izin untuk mengakses aksi ini.');
        }
        

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $forum = Forum::findOrFail($id);
        $forum->update($request->only('title', 'description'));

        return redirect()->route('forum.show', $forum->id)->with('success', 'Forum berhasil diperbarui!');
    }

    // Menghapus data forum
    public function destroy($id)
    {
        $forum = Forum::findOrFail($id);
        // cek user access
        if ($forum->username !== Auth::user()->username) {
            return back()->with('error', 'Kamu tidak memiliki izin untuk mengakses aksi ini.');
        }
        
        $forum->delete();

        return redirect()->route('forum', $forum->id)->with('success', 'Forum berhasil dihapus!');
    }

    // reply 
    public function reply(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'reply' => 'required|string',
        ]);

        ForumReply::create([
            'forum_id' => $id,
            'username' => $user->username,
            'reply' => $request->reply,
        ]);

        return back()->with('success', 'Balasan berhasil ditambahkan!');
    }

    // like function
    public function like($id)
    {
        $user = Auth::user();
        
        $forum = Forum::findOrFail($id);
        $username = $user->username; // Ganti ini ke auth user kalau udah pakai login

        // Cek apakah user sudah like
        $existingLike = ForumLike::where('forum_id', $id)->where('username', $username)->first();

        if ($existingLike) {
            $existingLike->delete(); // Unlike
        } else {
            ForumLike::create([
                'forum_id' => $id,
                'username' => $username,
            ]);
        }

        return back();
    }
}