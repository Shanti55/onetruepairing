<?php

namespace App\Events;

use App\Models\JobBid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BidPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bid;

    /**
     * Create a new event instance.
     */
    public function __construct(JobBid $bid)
    {
        // Pure bid model ko load kar rahe hain vendor relationship ke saath
        // Taaki vendor ka naam aur ID dono mil sakein
        $this->bid = $bid->load('vendor:id,name');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        // Ye channel JS mein window.Echo.channel('auction.' + jobId) se match karega
        return new Channel('auction.' . $this->bid->job_post_id);
    }

    /**
     * Broadcast ka name jo JS listen karega (.listen('.bid.placed', ...))
     */
    public function broadcastAs()
    {
        return 'bid.placed';
    }

    

    /**
     * Kaunsa data frontend (JavaScript) ko bhejna hai.
     * YAHAN CHANGES KIYE GAYE HAIN.
     */
    public function broadcastWith()
{
    return [
        'amount' => $this->bid->amount,
        'job_post_id' => $this->bid->job_post_id,
        'vendor_id' => $this->bid->vendor_id, // 👈 Ye line honi chahiye!
        'vendor_name' => $this->bid->vendor->name,
        'time' => 'Just now',
    ];
}

    
}