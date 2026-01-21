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
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->string('analytics_heading')->nullable();
            $table->string('analytics_subheading')->nullable();
            $table->string('analytics_total_listing')->nullable();
            $table->string('analytics_search_traffic')->nullable();
            $table->string('analytics_online_impression')->nullable();
            $table->string('analytics_organic_traffic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('analytics_heading');
            $table->dropColumn('analytics_subheading');
            $table->dropColumn('analytics_total_listing');
            $table->dropColumn('analytics_search_traffic');
            $table->dropColumn('analytics_online_impression');
            $table->dropColumn('analytics_organic_traffic');
        });
    }
};
