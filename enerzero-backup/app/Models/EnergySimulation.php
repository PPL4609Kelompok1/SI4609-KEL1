<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergySimulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'simulation_name',
        'data_before',
        'data_after',
        'energy_consumption_before_kwh',
        'energy_consumption_after_kwh',
        'energy_saved_kwh',
        'cost_before',
        'cost_after',
        'cost_saved',
        'electricity_tariff',
        'notes',
    ];

    protected $casts = [
        'data_before' => 'array',
        'data_after' => 'array',
        'energy_consumption_before_kwh' => 'decimal:2',
        'energy_consumption_after_kwh' => 'decimal:2',
        'energy_saved_kwh' => 'decimal:2',
        'cost_before' => 'decimal:2',
        'cost_after' => 'decimal:2',
        'cost_saved' => 'decimal:2',
        'electricity_tariff' => 'decimal:2',
    ];

    /**
     * Get the user that owns the simulation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 