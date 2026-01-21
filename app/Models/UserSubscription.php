<?php

namespace App\Models;

use App\Enums\UserSubscriptionStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'status' => UserSubscriptionStatus::class,
    ];

    protected $appends = [
        'active_status_formatted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class,'subscription_plan_id');
    }

    public function getActiveStatusFormattedAttribute()
    {

        $endDate = Carbon::createFromFormat('Y-m-d',$this->end_date);
        if(Carbon::now()->lt($endDate)){
            return '';
        }else{
            return '/ expired';
        }

    }

}
