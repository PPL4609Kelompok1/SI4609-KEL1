<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class MissionController extends Controller
{
    /**
     * Simulasi menghitung data dan menyimpan ke session
     * (Misalnya dipanggil dari halaman sebelumnya, seperti saat simulasi selesai)
     */
    public function simulateAndRedirect()
    {
        // Simulasi data perbandingan (bisa dari database, perhitungan, dsb)
        $comparisonData = [
            'trend' => 'increase', // atau 'decrease'
            'percentage_change' => 252.5,
            'current_month' => 310,
            'previous_month' => 88
        ];

        // Simpan ke session
        session(['comparisonData' => $comparisonData]);
    }

    /**
     * Menampilkan halaman challenge dengan summary data
     */
    public function index()
    {
        // Ambil data dari Report model (sama seperti di EnergyUsageReportController)
        $reports = Report::all();

        if ($reports->count() > 0) {
            // Ambil 2 data terakhir untuk perbandingan (berdasarkan ID terbesar)
            $latest = $reports->sortByDesc('id')->take(2)->values();
            $current = $latest->first() ? $latest->first()->usage : 0;
            $previous = $latest->count() > 1 ? $latest->get(1)->usage : 0;

            $percentageChange = $previous > 0 ? number_format((($current - $previous) / $previous) * 100, 2) : 0;
            $trend = $current >= $previous ? 'increase' : 'decrease';

            $comparisonData = [
                'current_month' => $current,
                'previous_month' => $previous,
                'percentage_change' => abs($percentageChange),
                'trend' => $trend
            ];
        } else {
            // Jika tidak ada data, set default
            $comparisonData = [
                'current_month' => 0,
                'previous_month' => 0,
                'percentage_change' => 0,
                'trend' => 'no_change'
            ];
        }

        // Kelompokkan data usage per bulan untuk analisis
        $monthlyUsage = $reports->groupBy('month')->map(function ($group) {
            return $group->sum('usage');
        });

        // Debug: uncomment baris ini untuk debugging
        // dd($reports->toArray(), $comparisonData);

        // Kirim ke view
        return view('mission.mission', compact('comparisonData', 'monthlyUsage'));
    }

     // Method untuk start challenge
    public function startChallenge(Request $request)
    {
        try {
            $request->validate([
                'challenge_key' => 'required|string',
                'title' => 'required|string',
                'description' => 'required|string',
                'icon' => 'required|string',
                'difficulty' => 'required|in:Easy,Medium,Hard'
            ]);

            $userId = Auth::id();

            // Check if user already has this challenge
            $existingChallenge = UserChallenge::where('user_id', $userId)
                ->where('challenge_key', $request->challenge_key)
                ->first();

            if ($existingChallenge) {
                return response()->json([
                    'success' => false,
                    'message' => 'Challenge already exists'
                ], 400);
            }

            // Create new challenge
            $challenge = UserChallenge::create([
                'user_id' => $userId,
                'challenge_key' => $request->challenge_key,
                'title' => $request->title,
                'description' => $request->description,
                'icon' => $request->icon,
                'points' => 10,
                'difficulty' => $request->difficulty,
                'status' => 'in_progress',
                'started_at' => now(),
                'progress_percentage' => rand(10, 30)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Challenge started successfully',
                'challenge' => $challenge
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error starting challenge: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk update progress
    public function updateProgress(Request $request, $id)
    {
        try {
            $request->validate([
                'progress' => 'required|integer|min:0|max:100'
            ]);

            $challenge = UserChallenge::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $challenge->updateProgress($request->progress);

            return response()->json([
                'success' => true,
                'message' => 'Progress updated successfully',
                'challenge' => $challenge->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating progress: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk complete challenge
    public function completeChallenge($id)
    {
        try {
            $challenge = UserChallenge::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $challenge->completeChallenge();

            return response()->json([
                'success' => true,
                'message' => 'Challenge completed successfully',
                'challenge' => $challenge->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error completing challenge: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk get user challenges
    public function getUserChallenges()
    {
        try {
            $userId = Auth::id();
            
            $inProgressChallenges = UserChallenge::where('user_id', $userId)
                ->inProgress()
                ->get();

            $completedChallenges = UserChallenge::where('user_id', $userId)
                ->completed()
                ->get();

            return response()->json([
                'success' => true,
                'in_progress' => $inProgressChallenges,
                'completed' => $completedChallenges
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching challenges: ' . $e->getMessage()
            ], 500);
        }
    }
}