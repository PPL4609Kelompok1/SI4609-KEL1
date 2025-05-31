<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'user_devices';

    protected $fillable = [
        'user_id',
        'name',
        'wattage',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk mendapatkan perangkat milik user tertentu
    public function scopeUserDevices($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
} 