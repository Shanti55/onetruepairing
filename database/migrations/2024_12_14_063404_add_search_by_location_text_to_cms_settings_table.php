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
            $table->text('search_by_location_text')->nullable();
            $table->string('search_by_location_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('search_by_location_text');
            $table->dropColumn('search_by_location_img');
        });
    }
};
