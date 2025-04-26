<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    protected $fillable = [
        'forum_id',
        'username',
        'reply',
    ];
    
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }
}
