<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSubscription;
use Carbon\Carbon;

class UpdateUserSubscriptionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update expired user subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $expiredSubscriptions = UserSubscription::where('end_date', '<', $today)
            ->where('status', 'active') // Ensure only active ones are updated
            ->update(['status' => 'expired']);

        $this->info("Updated {$expiredSubscriptions} subscriptions to expired.");
    }
}
