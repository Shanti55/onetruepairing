<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AuctionWinnerNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public string $jobTitle;
    public float  $bidAmount;
    public int    $jobId;

    public function __construct(string $jobTitle, float $bidAmount, int $jobId)
    {
        $this->jobTitle  = $jobTitle;
        $this->bidAmount = $bidAmount;
        $this->jobId     = $jobId;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function broadcastType(): string
    {
        return 'auction.winner';
    }

    public function toArray($notifiable): array
    {
        return [
            'title'      => '🏆 You Won the Auction!',
            'message'    => "Congratulations! You have been selected for '{$this->jobTitle}'.",
            'highlight'  => 'Winning Bid: ₹' . number_format($this->bidAmount),
            'icon'       => 'bi-trophy-fill',
            'type'       => 'auction_winner',
            'job_id'     => $this->jobId,
            'job_title'  => $this->jobTitle,
            'action_url' => url('/service-provider/bid-status'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}