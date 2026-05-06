<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AuctionLoserNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public string $jobTitle;
    public string $winnerName;
    public int    $jobId;

    public function __construct(string $jobTitle, string $winnerName, int $jobId)
    {
        $this->jobTitle   = $jobTitle;
        $this->winnerName = $winnerName;
        $this->jobId      = $jobId;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function broadcastType(): string
    {
        return 'auction.result';
    }

    public function toArray($notifiable): array
    {
        return [
            'title'      => '📋 Auction Result — ' . $this->jobTitle,
            'message'    => "'{$this->jobTitle}' has been awarded to {$this->winnerName}. Thank you for participating!",
            'highlight'  => 'Your EMD will be refunded within 4–5 working days.',
            'icon'       => 'bi-clock-history',
            'type'       => 'auction_result',
            'job_id'     => $this->jobId,
            'job_title'  => $this->jobTitle,
            'winner'     => $this->winnerName,
            'action_url' => url('/service-provider/bid-status'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}