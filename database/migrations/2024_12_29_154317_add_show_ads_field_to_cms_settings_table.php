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
            $table->integer('show_home_ad_one')->default(0);
            $table->integer('show_home_ad_two')->default(0);
            $table->integer('show_browse_ad_one')->default(0);
            $table->integer('show_browse_ad_two')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('show_home_ad_one');
            $table->dropColumn('show_home_ad_two');
            $table->dropColumn('show_browse_ad_one');
            $table->dropColumn('show_browse_ad_two');
        });
    }
};
