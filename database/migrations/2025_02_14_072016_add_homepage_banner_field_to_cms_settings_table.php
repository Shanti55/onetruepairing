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
            $table->text('homepage_banner_web')->nullable();
            $table->text('homepage_banner_mobile')->nullable();
            $table->text('homepage_banner_web_link')->nullable();
            $table->text('homepage_banner_mobile_link')->nullable();
            $table->integer('homepage_banner_web_show')->default(0);
            $table->integer('homepage_banner_mobile_show')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('homepage_banner_web');
            $table->dropColumn('homepage_banner_mobile');
            $table->dropColumn('homepage_banner_web_link');
            $table->dropColumn('homepage_banner_mobile_link');
            $table->dropColumn('homepage_banner_web_show');
            $table->dropColumn('homepage_banner_mobile_show');
        });
    }
};
