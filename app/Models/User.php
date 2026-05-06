<?php

namespace App\Models;

use App\Enums\UserOfflineVerification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'primary_mobile_number',
        'offline_verification',
        'role_id',
        'referral_code',
        'created_by',
        'referred_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'offline_verification' => UserOfflineVerification::class,
        ];
    }
    protected $appends = ['rating'];
    public function userprofile()
    {
        return $this->morphOne(UserProfile::class, 'profileable');
    }

    public function adminprofile()
    {
        return $this->morphOne(AdminProfile::class, 'profileable');
    }

    public function serviceproviderprofile()
    {
        return $this->morphOne(ServiceProviderProfile::class, 'profileable');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isServiceProvider()
    {
        return $this->role === 'service-provider';
    }

    public function subscriptionPlan()
    {
        return $this->hasOne(UserSubscription::class,'user_id')->where('is_current', 1);
    }

    public function activeSubscriptionPlan()
    {
        return $this->hasOne(UserSubscription::class,'user_id')->where('is_current', 1)->whereIn('status', ['active','on_trial']);
    }

    public function getRatingAttribute()
    {
        if ($this->isServiceProvider()) {
            $jobCount = JobPost::where('assigned_to', $this->id)->whereNotNull('rating')->count();
            $jobTotalRating = JobPost::where('assigned_to', $this->id)->sum('rating');
            if($this->serviceproviderprofile && $this->serviceproviderprofile->rating_type == 'manual'){
                return $this->serviceproviderprofile->manual_rating;
            }else{
                return $jobCount > 0 ? round($jobTotalRating / $jobCount) : 0;
            }

        }

        return 0;
    }


    // Define the 'activeSubscription' scope
    public function scopeActiveSubscription($query)
    {
        return $query->whereHas('subscriptionPlan', function ($query) {
            $query->whereIn('status', ['active','on_trial'])
                ->where(function ($query) {
                    $query->whereDate('end_date', '>=', Carbon::now()->toDateString());
            });
        });

    }

    public function scopeOfType($query, $type)
    {
        return $query->where('role', $type);
    }

    public function files()
    {
        return $this->hasMany(Media::class);
    }

    public function role_permission()
    {
        return $this->belongsTo(RolesPermission::class,'role_id');
    }

    public function referredBy(){
        return $this->belongsTo(User::class,'referred_by');
    }

    // app/Models/User.php mein add karein
public function receivesBroadcastNotificationsOn(): string
{
    return 'App.Models.User.'.$this->id;
}
}
