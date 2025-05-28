<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        
        $query = Education::query();
        
        if ($category) {
            $query->where('category', $category);
        }
        
        $educations = $query->latest()->paginate(9);
        $categories = Education::distinct()->pluck('category');
        
        return view('education.index', compact('educations', 'categories', 'category'));
    }

    public function show(Education $education)
    {
        return view('education.show', compact('education'));
    }
}
