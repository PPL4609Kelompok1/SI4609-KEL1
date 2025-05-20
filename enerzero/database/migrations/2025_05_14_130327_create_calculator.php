<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculator', function (Blueprint $table) {
            $table->id();

            // Ganti user_id foreign key → username string
            $table->string('username'); // tidak pakai foreign key

            $table->string('device_name');         
            $table->float('power_watt');           
            $table->float('hours_per_day');        
            $table->integer('days');

            $table->float('total_kwh');
            $table->float('cost_estimate');        

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculator');
    }
};
