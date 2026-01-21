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
            $table->string('header_heading')->nullable();
            $table->string('header_highlight')->nullable();
            $table->string('search_bar_heading')->nullable();
            $table->string('search_bar_highlight')->nullable();
            $table->string('header_banner_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('header_heading');
            $table->dropColumn('header_highlight');
            $table->dropColumn('search_bar_heading');
            $table->dropColumn('search_bar_highlight');
            $table->dropColumn('header_banner_img');
        });
    }
};
