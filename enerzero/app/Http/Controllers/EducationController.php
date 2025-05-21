<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EducationService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EducationController extends Controller
{
    protected $educationService;

    public function __construct(EducationService $educationService)
    {
        $this->educationService = $educationService;
    }

    public function index(Request $request)
    {
        $educations = $this->educationService->getEducations(
            $request->get('page', 1),
            9
        );
        
        if ($request->has('category')) {
            $filteredItems = collect($educations->items())->filter(function ($item) use ($request) {
                return $item['category'] === $request->category;
            });
            
            $educations = new \Illuminate\Pagination\LengthAwarePaginator(
                $filteredItems,
                $filteredItems->count(),
                9,
                $request->get('page', 1),
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        return view('education.index', compact('educations'));
    }

    public function show($id)
    {
        $education = collect($this->educationService->getEducations()->items())
            ->firstWhere('id', $id);
        
        if (!$education) {
            abort(404);
        }

        return view('education.show', compact('education'));
    }

    public function saved()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat artikel tersimpan.');
        }
        
        // Get saved education IDs from session
        $savedIds = session('saved_educations', []);
        $savedEducations = collect($this->educationService->getEducations()->items())
            ->filter(function ($education) use ($savedIds) {
                return in_array($education['id'], $savedIds);
            });

        return view('education.saved', compact('savedEducations'));
    }

    public function toggleSave($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $education = collect($this->educationService->getEducations()->items())
            ->firstWhere('id', $id);

        if (!$education) {
            return response()->json(['error' => 'Education not found'], 404);
        }

        // Get current saved educations from session
        $savedEducations = session('saved_educations', []);
        
        if (in_array($id, $savedEducations)) {
            // Remove from saved
            $savedEducations = array_diff($savedEducations, [$id]);
            $saved = false;
        } else {
            // Add to saved
            $savedEducations[] = $id;
            $saved = true;
        }

        // Update session
        session(['saved_educations' => $savedEducations]);

        return response()->json(['saved' => $saved]);
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