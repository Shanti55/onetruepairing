<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobPost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpireOldAuctions extends Command
{
    protected $signature   = 'auctions:expire';
    protected $description = 'Auto-close auctions, trash old jobs, delete old notifications';

    public function handle()
    {
        $now   = Carbon::now();
        $admin = User::where('role', 'admin')->first();

        // ── 1. Live auctions jo end ho gayi → close ───────────────────────
        $expired = JobPost::where('auction_status', 'live')
            ->where('auction_end', '<', $now)
            ->get();

        foreach ($expired as $job) {
            $job->update([
                'auction_status' => 'closed',
                'status'         => 'closed',
            ]);
        }

        if ($expired->count() > 0 && $admin) {
            $admin->notify(new \App\Notifications\AuctionAutoClosedNotification(
                $expired->count()
            ));
        }

        // ── 2. 30 din purani closed jobs → soft delete ────────────────────
        $oldJobs = JobPost::whereIn('status', ['closed', 'completed', 'assigned'])
            ->where('updated_at', '<', $now->copy()->subDays(30))
            ->get();

        foreach ($oldJobs as $job) {
            $job->delete();
        }

        if ($oldJobs->count() > 0 && $admin) {
            $admin->notify(new \App\Notifications\JobsAutoTrashedNotification(
                $oldJobs->count(),
                $oldJobs->pluck('title')->toArray()
            ));
        }

        // ── 3. 15 din purani notifications → delete ───────────────────────
        $deletedNotifs = DB::table('notifications')
            ->where('created_at', '<', $now->copy()->subDays(15))
            ->delete();

        $this->info(
            'Expired: '       . $expired->count()   .
            ' | Jobs trashed: ' . $oldJobs->count()  .
            ' | Notifications deleted: ' . $deletedNotifs
        );

        return 0;
    }
}