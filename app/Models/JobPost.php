<?php

namespace App\Models;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => JobStatus::class,
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class,'posted_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function progress()
    {
        return $this->hasMany(JobProgress::class);
    }

    // ✅ ADD THIS FOR BIDDING
    public function bids()
    {
        return $this->hasMany(JobBid::class, 'job_post_id');
    }
}
