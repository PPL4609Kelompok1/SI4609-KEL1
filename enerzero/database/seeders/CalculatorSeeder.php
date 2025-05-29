<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calculator;
use App\Models\User;

class CalculatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Langsung gunakan username 'enerzero'
        $username = 'enerzero';

        $calculatorData = [
            [
                'username' => $username,
                'device_name' => 'TV LED',
                'power_watt' => 80,
                'hours_per_day' => 4,
                'days' => 30,
                'total_kwh' => (80 * 4 * 30) / 1000,
                'cost_estimate' => ((80 * 4 * 30) / 1000) * 1500,
            ],
            [
                'username' => $username,
                'device_name' => 'Kulkas',
                'power_watt' => 100,
                'hours_per_day' => 24,
                'days' => 30,
                'total_kwh' => (100 * 24 * 30) / 1000,
                'cost_estimate' => ((100 * 24 * 30) / 1000) * 1500,
            ],
            [
                'username' => $username,
                'device_name' => 'AC',
                'power_watt' => 350,
                'hours_per_day' => 6,
                'days' => 30,
                'total_kwh' => (350 * 6 * 30) / 1000,
                'cost_estimate' => ((350 * 6 * 30) / 1000) * 1500,
            ],
            [
                'username' => $username,
                'device_name' => 'Mesin Cuci',
                'power_watt' => 300,
                'hours_per_day' => 1,
                'days' => 8,  // Asumsi penggunaan 8 hari dalam sebulan
                'total_kwh' => (300 * 1 * 8) / 1000,
                'cost_estimate' => ((300 * 1 * 8) / 1000) * 1500,
            ],
            [
                'username' => $username,
                'device_name' => 'Lampu LED',
                'power_watt' => 10,
                'hours_per_day' => 5,
                'days' => 30,
                'total_kwh' => (10 * 5 * 30) / 1000,
                'cost_estimate' => ((10 * 5 * 30) / 1000) * 1500,
            ],
             [
                'username' => $username,
                'device_name' => 'Dispenser Air',
                'power_watt' => 300,
                'hours_per_day' => 1,
                'days' => 30,
                'total_kwh' => (300 * 1 * 30) / 1000,
                'cost_estimate' => ((300 * 1 * 30) / 1000) * 1500,
            ],
            [
                'username' => $username,
                'device_name' => 'Setrika',
                'power_watt' => 350,
                'hours_per_day' => 0.5,  // Asumsi 30 menit per hari
                'days' => 12, //Asumsi 12 hari pakai
                'total_kwh' => (350 * 0.5 * 12) / 1000,
                'cost_estimate' => ((350 * 0.5 * 12) / 1000) * 1500,
            ],
            [
                'username' => $username,
                'device_name' => 'Laptop',
                'power_watt' => 60,
                'hours_per_day' => 8,
                'days' => 30,
                'total_kwh' => (60 * 8 * 30) / 1000,
                'cost_estimate' => ((60 * 8 * 30) / 1000) * 1500,
            ],
        ];

        foreach ($calculatorData as $data) {
            Calculator::create($data);
        }
    }
}
