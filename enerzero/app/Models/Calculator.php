<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calculator extends Model
{
    use HasFactory;

    protected $table = 'calculator';

    protected $fillable = [
        'username',
        'device_name',
        'power_watt',
        'hours_per_day',
        'days',
        'total_kwh',
        'cost_estimate',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
