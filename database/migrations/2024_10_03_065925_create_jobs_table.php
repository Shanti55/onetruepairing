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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posted_by')->nullable();
            $table->string('title')->nullable();
            $table->string('location')->nullable();
            $table->string('job_type')->nullable();
            $table->decimal('cost')->default(0);
            $table->string('duration_type')->nullable();//Hours/Days/Months
            $table->string('duration_value')->nullable();
            $table->string('status')->default('open');
            $table->text('description')->nullable();
            $table->foreignId('assigned_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
