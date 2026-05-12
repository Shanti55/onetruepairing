<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


app()->singleton(Schedule::class, function ($app) {
    return tap(new Schedule(), function (Schedule $schedule) {

        // ── Existing ──────────────────────────────────────────────────────
        $schedule->command('subscriptions:expire')->daily();

        // ✅ Auto-close expired live auctions — har minute check karo
       $schedule->command('auctions:expire')->everyMinute();
$schedule->command('subscriptions:expire')->daily();
    });
});