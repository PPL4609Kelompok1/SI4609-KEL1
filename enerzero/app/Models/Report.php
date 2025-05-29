<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['month', 'usage'];

    // Cast usage sebagai float, just in case
    protected $casts = [
        'usage' => 'float',
    ];

    // Scope untuk memfilter data berdasarkan ambang batas
    public function scopeGood($query)
    {
        return $query->where('usage', '<', 100);
    }

    public function scopeBad($query)
    {
        return $query->whereBetween('usage', [100, 199]);
    }

    public function scopeReallyBad($query)
    {
        return $query->where('usage', '>=', 200);
    }

    public function scopeReallyGood($query)
    {
        return $query->where('usage', '<', 50);
    }
}
