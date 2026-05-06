<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class BidOutbidNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public string $jobTitle;
    public float $newLowestAmount;
    public int $jobId;

    public function __construct(string $jobTitle, float $newLowestAmount, int $jobId)
    {
        $this->jobTitle        = $jobTitle;
        $this->newLowestAmount = $newLowestAmount;
        $this->jobId           = $jobId;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function broadcastType(): string
    {
        return 'bid.outbid';
    }

    // ── Database mein save hoga ───────────────────────────────────────────────
    public function toArray($notifiable): array
    {
        return [
            'title'      => '🔥 Competition Alert!',
            'message'    => "Someone just bid lower than you on '{$this->jobTitle}'.",
            'highlight'  => 'New Floor Price: ₹' . number_format($this->newLowestAmount),
            'icon'       => 'bi-graph-down-arrow',
            'type'       => 'outbid_warning',
            'job_id'     => $this->jobId,
            'job_title'  => $this->jobTitle,
            'action_url' => url('/service-provider/bid-status'),
        ];
    }

    // ── Frontend Echo listener ko jayega (sab fields same rakhni hain) ────────
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title'      => '🔥 Competition Alert!',
            'message'    => "Someone just bid lower than you on '{$this->jobTitle}'.",
            'highlight'  => 'New Floor Price: ₹' . number_format($this->newLowestAmount),
            'icon'       => 'bi-graph-down-arrow',
            'type'       => 'outbid_warning',
            'job_id'     => $this->jobId,
            'job_title'  => $this->jobTitle,
            'action_url' => url('/service-provider/bid-status'),
        ]);
    }
}