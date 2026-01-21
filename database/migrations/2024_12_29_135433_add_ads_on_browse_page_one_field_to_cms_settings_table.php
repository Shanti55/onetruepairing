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
            $table->text('ads_on_browse_page_one')->nullable();
            $table->text('ads_on_browse_page_two')->nullable();
            $table->text('ads_on_home_page_one')->nullable();
            $table->text('ads_on_home_page_two')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('ads_on_browse_page_one');
            $table->dropColumn('ads_on_browse_page_two');
            $table->dropColumn('ads_on_home_page_one');
            $table->dropColumn('ads_on_home_page_two');
        });
    }
};
