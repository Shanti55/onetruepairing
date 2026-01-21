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
    Schema::create('job_bids', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('job_post_id');
        $table->unsignedBigInteger('vendor_id');
        $table->decimal('amount', 10, 2);
        $table->text('message')->nullable();
        $table->enum('status', ['pending','accepted','rejected'])->default('pending');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_bids');
    }
};
