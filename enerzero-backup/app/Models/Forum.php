<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Forum extends Model
{
    protected $fillable = ['title', 'description', 'username'];
    
    public function replies()
    {
        return $this->hasMany(ForumReply::class);
    }

    public function likes()
    {
        return $this->hasMany(ForumLike::class);
    }
}
