<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkedContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content_type',
        'title',
        'category',
        'description',
        'thumbnail_url',
        'content_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 