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
        Schema::table('job_posts', function (Blueprint $table) {
            // Hum teen naye columns add kar rahe hain
            $table->timestamp('auction_start')->nullable()->after('status');
            $table->timestamp('auction_end')->nullable()->after('auction_start');
            $table->string('auction_status')->default('closed')->after('auction_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropColumn(['auction_start', 'auction_end', 'auction_status']);
        });
    }
};