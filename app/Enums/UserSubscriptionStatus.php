<?php

namespace App\Enums;

enum UserSubscriptionStatus: string
{
    case ON_TRIAL = 'on_trial';
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';
    case ON_TRIAL_EXPIRED = 'on_trial_expired';
    case SUSPENDED = 'suspended';

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'soft-success',
            self::PENDING => 'soft-warning',
            self::CANCELLED => 'soft-danger',
            self::EXPIRED => 'soft-warning',
            self::ON_TRIAL_EXPIRED => 'soft-warning',
            self::ON_TRIAL => 'soft-primary',
            self::SUSPENDED => 'soft-secondary',
        };
    }


}
