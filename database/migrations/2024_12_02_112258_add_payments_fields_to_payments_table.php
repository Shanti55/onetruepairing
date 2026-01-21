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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->nullable(); // Payment method
            $table->string('payment_type')->nullable(); // Default is 'debt'
            $table->string('transaction_id')->unique();  // Transaction ID (unique)
            $table->text('description')->nullable();      // Optional description
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('payment_type');
            $table->dropColumn('transaction_id');
            $table->dropColumn('description');
        });
    }
};
