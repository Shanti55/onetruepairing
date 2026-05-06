<?php

namespace App\Models;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ Add karo

class JobPost extends Model
{
    use HasFactory, SoftDeletes; // ✅ SoftDeletes add karo

    protected $guarded = [];

    protected $casts = [
        'status'        => JobStatus::class,
        'auction_start' => 'datetime',
        'auction_end'   => 'datetime',
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedVendor()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function progress()
    {
        return $this->hasMany(JobProgress::class);
    }

    public function bids()
    {
        return $this->hasMany(JobBid::class, 'job_post_id');
    }

    // public function media()
    // {
    //     return $this->hasMany(Media::class);
    // }

    public function isAuctionLive()
    {
        if (!$this->auction_start || !$this->auction_end) {
            return false;
        }
        return now()->between($this->auction_start, $this->auction_end);
    }

    public function getCurrentLowest()
    {
        return $this->bids()->min('amount') ?? $this->budget;
    }
}