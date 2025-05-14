<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::latest()->paginate(10);
        return view('education.index', compact('educations'));
    }

    public function show($id)
    {
        $education = Education::findOrFail($id);
        return view('education.show', compact('education'));
    }

    public function create()
    {
        return view('education.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('education', 'public');
            $validated['image'] = $imagePath;
        }

        Education::create($validated);

        return redirect()->route('education.index')
            ->with('success', 'Educational content created successfully.');
    }

    public function edit($id)
    {
        $education = Education::findOrFail($id);
        return view('education.edit', compact('education'));
    }

    public function update(Request $request, $id)
    {
        $education = Education::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('education', 'public');
            $validated['image'] = $imagePath;
        }

        $education->update($validated);

        return redirect()->route('education.index')
            ->with('success', 'Educational content updated successfully.');
    }

    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->delete();

        return redirect()->route('education.index')
            ->with('success', 'Educational content deleted successfully.');
    }
} 