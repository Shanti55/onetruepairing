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
        Schema::table('service_provider_profiles', function (Blueprint $table) {
            $table->string('rating_type')->default('auto');
            $table->decimal('manual_rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_provider_profiles', function (Blueprint $table) {
            $table->dropColumn('rating_type');
            $table->dropColumn('manual_rating');
        });
    }
};
