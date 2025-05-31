<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookmarked_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('content_type'); // 'article' atau 'video'
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->string('thumbnail_url');
            $table->string('content_url', 255); // URL artikel atau embed video dengan panjang maksimum 255 karakter
            $table->timestamps();

            // Mencegah duplikasi bookmark dengan panjang yang lebih pendek
            $table->unique(['user_id', 'content_url'], 'bookmarked_contents_unique');
        });
    }

    public function down()
    {
        Schema::table('bookmarked_contents', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('bookmarked_contents');
    }
}; 