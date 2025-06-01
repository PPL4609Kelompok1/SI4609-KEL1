<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
<<<<<<<< HEAD:enerzero fitur individu/database/migrations/0001_01_01_000003_create_reports_table.php
        Schema::create('reports', function (Blueprint $table) {
========
        Schema::create('favorite_stations', function (Blueprint $table) {
>>>>>>>> c9911f8695d68cb90c8dd37eaa5e76b20d50d85a:enerzero/database/migrations/2025_05_05_141532_create_favorite_stations_table.php
            $table->id();
            $table->string('month');        // ex: January, February
            $table->integer('usage');       // kWh used that month
            $table->timestamps();
        });
    }

    public function down(): void
    {
<<<<<<<< HEAD:enerzero fitur individu/database/migrations/0001_01_01_000003_create_reports_table.php
        Schema::dropIfExists('reports');
========
        Schema::dropIfExists('favorite_stations');
>>>>>>>> c9911f8695d68cb90c8dd37eaa5e76b20d50d85a:enerzero/database/migrations/2025_05_05_141532_create_favorite_stations_table.php
    }
};