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
            $table->string('about_us_heading')->nullable();
            $table->string('about_us_subheading')->nullable();
            $table->text('about_us_content')->nullable();
            $table->string('benefits_of_listings_heading')->nullable();
            $table->string('benefits_of_listings_subheading')->nullable();
            $table->text('benefits_of_listings_content')->nullable();
            $table->string('terms_and_conditions_heading')->nullable();
            $table->string('terms_and_conditions_subheading')->nullable();
            $table->text('terms_and_conditions_content')->nullable();
            $table->string('privacy_policy_heading')->nullable();
            $table->string('privacy_policy_subheading')->nullable();
            $table->text('privacy_policy_content')->nullable();
            $table->string('contact_us_img')->nullable();
            $table->string('contact_us_bg_img')->nullable();
            $table->string('address_first_lat')->nullable();
            $table->string('address_first_lng')->nullable();
            $table->string('address_second_lat')->nullable();
            $table->string('address_second_lng')->nullable();
            $table->integer('contact_us_dfa')->default(0);
            $table->integer('contact_us_dsa')->default(0);
            $table->integer('contact_us_dfm')->default(0);
            $table->integer('contact_us_dsm')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('about_us_heading');
            $table->dropColumn('about_us_subheading');
            $table->dropColumn('about_us_content');
            $table->dropColumn('benefits_of_listings_heading');
            $table->dropColumn('benefits_of_listings_subheading');
            $table->dropColumn('benefits_of_listings_content');
            $table->dropColumn('terms_and_conditions_heading');
            $table->dropColumn('terms_and_conditions_subheading');
            $table->dropColumn('terms_and_conditions_content');
            $table->dropColumn('privacy_policy_heading');
            $table->dropColumn('privacy_policy_subheading');
            $table->dropColumn('privacy_policy_content');
            $table->dropColumn('contact_us_img');
            $table->dropColumn('contact_us_bg_img');
            $table->dropColumn('address_first_lat');
            $table->dropColumn('address_first_lng');
            $table->dropColumn('address_second_lat');
            $table->dropColumn('address_second_lng');
            $table->dropColumn('contact_us_dfa');
            $table->dropColumn('contact_us_dsa');
            $table->dropColumn('contact_us_dfm');
            $table->dropColumn('contact_us_dsm');
        });
    }
};
