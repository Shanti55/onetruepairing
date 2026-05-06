<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBid extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_post_id', 
        'vendor_id', 
        'amount', 
        'message', 
        'status', 
        'attachment', 
        'previous_amount',
        // 🔥 YE DONO ADD KARNA ZAROORI HAI:
        'created_at',
        'updated_at'
    ];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}