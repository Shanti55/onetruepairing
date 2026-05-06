<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->string('hero_banner_1')->nullable();
            $table->string('hero_banner_2')->nullable();
            $table->string('hero_banner_3')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_banner_1','hero_banner_2','hero_banner_3']);
        });
    }
};