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
            $table->integer('display_address_one_footer')->default(0);
            $table->integer('display_address_two_footer')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('display_address_one_footer');
            $table->dropColumn('display_address_two_footer');
        });
    }
};
