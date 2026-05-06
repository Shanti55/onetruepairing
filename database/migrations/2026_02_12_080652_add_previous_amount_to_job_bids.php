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
        Schema::table('job_bids', function (Blueprint $table) {
            // PDF Flow ke liye ye column zaroori hai: Previous Bid track karne ke liye
            if (!Schema::hasColumn('job_bids', 'previous_amount')) {
                $table->decimal('previous_amount', 15, 2)->nullable()->after('amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_bids', function (Blueprint $table) {
            $table->dropColumn('previous_amount');
        });
    }
};