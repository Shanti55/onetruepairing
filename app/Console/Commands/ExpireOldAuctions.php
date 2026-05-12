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
    protected $description = 'Auto-close expired auctions, trash old jobs, delete old notifications';

    public function handle()
    {
        $now = Carbon::now();

        // ── 1. Expired live auctions → Under Verification ─────────────────
        // ✅ FIX: 'live' → 'open' (DB mein yahi value hai)
        $expired = JobPost::where('auction_status', 'open')
                          ->where('auction_end', '<', $now)
                          ->get();

        foreach ($expired as $job) {
            // ✅ FIX: status = 'under verification' (not 'closed')
            $job->update([
                'auction_status' => 'closed',
                'status'         => 'under verification',
            ]);

            // ✅ Notify ALL admins (not just first one)
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                DB::table('notifications')->insert([
                    'id'              => \Illuminate\Support\Str::uuid(),
                    'type'            => 'App\Notifications\AuctionAutoClosedNotification',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id'   => $admin->id,
                    'data'            => json_encode([
                        'title'      => '⏰ Auction Ended — Review Required',
                        'message'    => 'Job "' . $job->title . '" (EL#' . str_pad($job->id, 5, '0', STR_PAD_LEFT) . ') ki auction timing khatam ho gayi hai. Bids review karein aur winner declare karein.',
                        'job_id'     => $job->id,
                        'action_url' => url('admin/manage-bids/' . $job->id),
                    ]),
                    'read_at'    => null,
                    'deleted_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ── 2. 30 din purani closed/completed jobs → soft delete ──────────
        $oldJobs = JobPost::whereIn('status', ['completed', 'assigned'])
                          ->where('updated_at', '<', $now->copy()->subDays(30))
                          ->get();

        foreach ($oldJobs as $job) {
            $job->delete();
        }

        if ($oldJobs->count() > 0) {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                DB::table('notifications')->insert([
                    'id'              => \Illuminate\Support\Str::uuid(),
                    'type'            => 'App\Notifications\JobsAutoTrashedNotification',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id'   => $admin->id,
                    'data'            => json_encode([
                        'title'   => '🗑️ Old Jobs Auto-Trashed',
                        'message' => $oldJobs->count() . ' purani jobs automatically trash mein move kar di gayi hain (30 din se zyada purani).',
                    ]),
                    'read_at'    => null,
                    'deleted_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ── 3. 15 din purani notifications → delete ───────────────────────
        $deletedNotifs = DB::table('notifications')
                           ->where('created_at', '<', $now->copy()->subDays(15))
                           ->delete();

        $this->info(
            'Expired: '              . $expired->count()  .
            ' | Jobs trashed: '      . $oldJobs->count()  .
            ' | Notifications deleted: ' . $deletedNotifs
        );

        return 0;
    }
}