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
            $table->string('customer_agreement_heading')->nullable();
            $table->string('customer_agreement_subheading')->nullable();
            $table->text('customer_agreement_content')->nullable();
            $table->string('refund_policy_heading')->nullable();
            $table->string('refund_policy_subheading')->nullable();
            $table->text('refund_policy_content')->nullable();
            $table->string('faqs_heading')->nullable();
            $table->string('faqs_subheading')->nullable();
            $table->text('faqs_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_settings', function (Blueprint $table) {
            $table->dropColumn('customer_agreement_heading');
            $table->dropColumn('customer_agreement_subheading');
            $table->dropColumn('customer_agreement_content');
            $table->dropColumn('refund_policy_heading');
            $table->dropColumn('refund_policy_subheading');
            $table->dropColumn('refund_policy_content');
            $table->dropColumn('faqs_heading');
            $table->dropColumn('faqs_subheading');
            $table->dropColumn('faqs_content');
        });
    }
};
