<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('energy_simulations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('data_before')->nullable();
            $table->json('data_after')->nullable();
            $table->decimal('current_consumption', 10, 2);
            $table->decimal('changed_consumption', 10, 2);
            $table->decimal('savings', 10, 2);
            $table->decimal('cost_savings', 10, 2);
            $table->decimal('electricity_tariff', 10, 2);
            $table->string('tariff_group')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('energy_simulations');
    }
}; 