<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnergyUsage extends Model
{
    protected $table = 'user'; 

    protected $fillable = ['watt', 'recorded_at'];
}
