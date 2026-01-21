<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobBid extends Model
{
protected $fillable = [
    'job_post_id', 
    'vendor_id', 
    'amount', 
    'message', 
    // 'duration', // Ye column zaroori hai
    'attachment',
    'status'
];

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
