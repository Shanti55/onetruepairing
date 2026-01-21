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
            $table->text('ads_on_home_page_three')->nullable();
            $table->integer('show_home_ad_three')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('ads_on_home_page_three');
            $table->dropColumn('show_home_ad_three');
        });
    }
};
