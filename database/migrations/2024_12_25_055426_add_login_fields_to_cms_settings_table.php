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
            $table->string('login_heading')->nullable();
            $table->string('login_text')->nullable();
            $table->string('login_banner_img')->nullable();
            $table->string('signup_heading')->nullable();
            $table->string('signup_text')->nullable();
            $table->string('signup_banner_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            //
        });
    }
};
