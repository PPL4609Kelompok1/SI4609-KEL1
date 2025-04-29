<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use App\Models\ForumReply;
use App\Models\ForumLike;

class ForumController extends Controller
{
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

        Forum::create([
            'title' => $request->title,
            'description' => $request->description,
            'username' => 'Mas Agus Indihome' // Ganti kalau pakai auth
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
        return view('forum.edit', compact('forum'));
    }

    // Update data forum
    public function update(Request $request, $id)
    {
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
        $forum->delete();

        return redirect()->route('forum', $forum->id)->with('success', 'Forum berhasil dihapus!');
    }

    // reply 
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        ForumReply::create([
            'forum_id' => $id,
            'username' => 'Mas Agus', // Ganti sesuai user auth
            'reply' => $request->reply,
        ]);

        return back()->with('success', 'Balasan berhasil ditambahkan!');
    }

    // like function
    public function like($id)
    {
        $forum = Forum::findOrFail($id);
        $username = 'Mas Agus Indihome'; // Ganti ini ke auth user kalau udah pakai login

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