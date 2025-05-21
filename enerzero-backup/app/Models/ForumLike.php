<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumLike extends Model
{
    protected $fillable = [
        'forum_id',
        'username',
    ];
    
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }
}
