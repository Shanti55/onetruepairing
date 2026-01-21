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
            $table->integer('facebook_link_order')->default(1);
            $table->integer('linkedin_link_order')->default(2);
            $table->integer('instagram_link_order')->default(3);
            $table->integer('youtube_link_order')->default(4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('facebook_link_order');
            $table->dropColumn('linkedin_link_order');
            $table->dropColumn('instagram_link_order');
            $table->dropColumn('youtube_link_order');
        });
    }
};
