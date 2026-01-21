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
        Schema::table('service_provider_profiles', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            $table->string('company_tagline')->nullable();
            $table->text('categories')->nullable();
            $table->text('services')->nullable();
            $table->text('company_description')->nullable();
            $table->string('company_email')->nullable();
            $table->string('website')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('gallery')->nullable();
            $table->text('documents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_provider_profiles', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('company_tagline');
            $table->dropColumn('categories');
            $table->dropColumn('services');
            $table->dropColumn('company_description');
            $table->dropColumn('company_email');
            $table->dropColumn('website');
            $table->dropColumn('cover_image');
            $table->dropColumn('gallery');
            $table->dropColumn('documents');
        });
    }
};
