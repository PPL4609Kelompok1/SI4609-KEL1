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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Forum::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'username' => 'Mas Agus Indihome' // Ganti kalau pakai auth
        // ]);

        Forum::create([
            'title' => $request->title,
            'description' => $request->description,
            'username' => Auth::user()->username,
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
            abort(403, 'Unauthorized action.');
        }
        return view('forum.edit', compact('forum'));
    }

    // Update data forum
    public function update(Request $request, $id)
    {
        $forum = Forum::findOrFail($id);
        // cek user access
        if ($forum->username !== Auth::user()->username) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $forum->update($request->only('title', 'description'));
        return redirect()->route('forum.show', $forum->id)->with('success', 'Forum berhasil diperbarui!');
    }

    // Menghapus data forum
    public function destroy($id)
    {
        $forum = Forum::findOrFail($id);
        // cek user access
        if ($forum->username !== Auth::user()->username) {
            abort(403, 'Unauthorized action.');
        }
        $forum->delete();

        return redirect()->route('forum', $forum->id)->with('success', 'Forum berhasil dihapus!');
    }

    // reply 
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        // ForumReply::create([
        //     'forum_id' => $id,
        //     'username' => 'Mas Agus',
        //      // Ganti sesuai user auth
        //     'reply' => $request->reply,
        // ]);

        ForumReply::create([
            'forum_id' => $id,
            'username' => Auth::user()->username,
            'reply' => $request->reply,
        ]);

        return back()->with('success', 'Balasan berhasil ditambahkan!');
    }

    // like function
    public function like($id)
    {
        $forum = Forum::findOrFail($id);
        $username = 'Mas Agus Indihome'; 
        // Ganti ini ke auth user kalau udah pakai login

        // Cek apakah user sudah like
        $existingLike = ForumLike::where('forum_id', $id)->where('username', $username)->first();

        if ($existingLike) {
            $existingLike->delete(); // Unlike
        } else {
            ForumLike::create([
                'forum_id' => $id,
                'username' => $username,
                // $username = Auth::user()->username,
            ]);
        }

        return back();
    }
}