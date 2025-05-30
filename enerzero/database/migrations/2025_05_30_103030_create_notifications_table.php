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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ID UUID untuk notifikasi
            $table->string('type'); // Class dari notifikasi, misal App\Notifications\EnergyAlertNotification
            $table->morphs('notifiable'); // user_id & user_type
            $table->json('data'); // Isi data notifikasi (message, title, dsb)
            $table->enum('category', ['energy', 'challenge', 'general'])->default('general'); // Custom tambahan
            $table->timestamp('read_at')->nullable(); // Kapan dibaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
