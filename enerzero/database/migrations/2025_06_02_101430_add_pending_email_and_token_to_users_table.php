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
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk menyimpan email baru yang sedang diverifikasi
            if (!Schema::hasColumn('users', 'pending_email')) {
                $table->string('pending_email')->nullable()->after('email');
            }
            // Kolom untuk menyimpan token verifikasi email (jika dibutuhkan)
            if (!Schema::hasColumn('users', 'email_change_token')) {
                $table->string('email_change_token', 60)->nullable()->unique()->after('pending_email');
            }
            // Kolom untuk menyimpan kapan token itu dibuat/valid (opsional, tapi bagus untuk expiry)
            if (!Schema::hasColumn('users', 'email_change_token_expires_at')) {
                $table->timestamp('email_change_token_expires_at')->nullable()->after('email_change_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'pending_email')) {
                $table->dropColumn('pending_email');
            }
            if (Schema::hasColumn('users', 'email_change_token')) {
                $table->dropColumn('email_change_token');
            }
            if (Schema::hasColumn('users', 'email_change_token_expires_at')) {
                $table->dropColumn('email_change_token_expires_at');
            }
        });
    }
};