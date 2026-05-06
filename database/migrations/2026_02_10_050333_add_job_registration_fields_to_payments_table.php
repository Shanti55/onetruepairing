<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('payments', function (Blueprint $table) {

        $table->unsignedBigInteger('job_id')->nullable()->after('user_id');

        $table->enum('payment_for', ['subscription', 'job_registration'])
              ->default('subscription')
              ->after('job_id');

        $table->decimal('registration_fee', 10, 2)
              ->nullable()
              ->after('payment_for');

        $table->string('invoice_number')->nullable()->after('registration_fee');

        $table->enum('refund_status', ['pending', 'refunded', 'not_applicable'])
              ->default('not_applicable')
              ->after('invoice_number');

        $table->timestamp('refunded_at')->nullable()->after('refund_status');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('payments', function (Blueprint $table) {

        $table->dropColumn([
            'job_id',
            'payment_for',
            'registration_fee',
            'invoice_number',
            'refund_status',
            'refunded_at',
        ]);
    });
}

};
