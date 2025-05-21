<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'title',
        'content',
        'category',
        'image'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'education_user');
    }

    public function isSavedByUser($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }
} 