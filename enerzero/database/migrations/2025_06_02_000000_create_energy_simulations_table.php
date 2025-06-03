<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('energy_simulations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Assuming users table exists
            $table->string('simulation_name')->nullable();
            $table->json('data_before'); // To store current appliances and usage
            $table->json('data_after');  // To store changed appliances and usage
            $table->decimal('energy_consumption_before_kwh', 10, 2);
            $table->decimal('energy_consumption_after_kwh', 10, 2);
            $table->decimal('energy_saved_kwh', 10, 2);
            $table->decimal('cost_before', 15, 2);
            $table->decimal('cost_after', 15, 2);
            $table->decimal('cost_saved', 15, 2);
            $table->decimal('electricity_tariff', 10, 2); // e.g., Rp per kWh
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_simulations');
    }
};