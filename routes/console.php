<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


app()->singleton(Schedule::class, function ($app) {
    return tap(new Schedule(), function (Schedule $schedule) {
        $schedule->command('subscriptions:expire')->daily();
    });
});
