<?php
// app/Notifications/AuctionAutoClosedNotification.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AuctionAutoClosedNotification extends Notification
{
    public int $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title'      => '🔔 ' . $this->count . ' Auction(s) Auto-Closed',
            'message'    => $this->count . ' auction(s) have been automatically closed as their end time has passed.',
            'icon'       => 'bi-clock-history',
            'type'       => 'auction_auto_closed',
            'action_url' => url('/admin/job-posts'),
        ];
    }
}