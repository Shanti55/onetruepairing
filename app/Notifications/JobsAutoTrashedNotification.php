<?php
// app/Notifications/JobsAutoTrashedNotification.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class JobsAutoTrashedNotification extends Notification
{
    public int   $count;
    public array $titles;

    public function __construct(int $count, array $titles)
    {
        $this->count  = $count;
        $this->titles = $titles;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $list = implode(', ', array_slice($this->titles, 0, 3));
        $more = count($this->titles) > 3 ? ' +' . (count($this->titles) - 3) . ' more' : '';

        return [
            'title'      => '🗑️ ' . $this->count . ' Job(s) Moved to Trash',
           'message' => $this->count . ' old job(s) have been auto-trashed (older than 7 days): ' . $list . $more,
            'highlight'  => 'You can restore them from Job Posts → Trash',
            'icon'       => 'bi-trash3',
            'type'       => 'jobs_auto_trashed',
            'action_url' => url('/admin/job-posts/trash'),
        ];
    }
}