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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('profileable_type'); // To store the model type
            $table->unsignedBigInteger('profileable_id'); // To store the model ID

            $table->string('avatar')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('landmark')->nullable();
            $table->string('alternate_contact_number')->nullable();
            $table->string('address_type')->nullable();
            $table->string('pan_card_no')->nullable();
            $table->string('pan_card_name')->nullable();
            $table->string('pan_card_image')->nullable();
            $table->string('aadhar_card_no')->nullable();
            $table->string('aadhar_card_name')->nullable();
            $table->string('aadhar_card_image')->nullable();
            $table->timestamps();
            // Set up the polymorphic index
            $table->index(['profileable_type', 'profileable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
