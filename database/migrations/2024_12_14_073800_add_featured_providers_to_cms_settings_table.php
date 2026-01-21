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
            $table->string('featured_provider_heading')->nullable();
            $table->string('featured_provider_subheading')->nullable();
            $table->text('featured_providers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('featured_provider_heading');
            $table->dropColumn('featured_provider_subheading');
            $table->dropColumn('featured_providers');
        });
    }
};
