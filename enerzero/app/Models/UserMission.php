<?php
// app/Models/UserChallenge.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'challenge_key',
        'title',
        'description',
        'icon',
        'points',
        'difficulty',
        'status',
        'progress_percentage',
        'started_at',
        'completed_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk filter berdasarkan status
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Method untuk start challenge
    public function startChallenge()
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now(),
            'progress_percentage' => rand(10, 30) // Random initial progress
        ]);
    }

    // Method untuk update progress
    public function updateProgress($percentage)
    {
        $this->update([
            'progress_percentage' => min(100, max(0, $percentage))
        ]);

        // Auto complete jika progress 100%
        if ($percentage >= 100) {
            $this->completeChallenge();
        }
    }

    // Method untuk complete challenge
    public function completeChallenge()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100
        ]);
    }

    // Get days since started
    public function getDaysInProgressAttribute()
    {
        if ($this->started_at) {
            return $this->started_at->diffInDays(now());
        }
        return 0;
    }
}