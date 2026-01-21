<?php

namespace App\Enums;

enum JobStatus: string
{
    case OPEN = 'open';
    case PENDING = 'pending';
    case ASSIGNED = 'assigned';
    case ON_HOLD = 'on hold';
    case CLOSED = 'closed';
    case COMPLETED = 'completed';
    case NOT_STARTED = 'not started';
    case IN_PROGRESS = 'in progress';
    case UNDER_VERIFICATION = 'under verification';
    case VERIFIED = 'verified';

    public function color(): string
    {
        return match ($this) {
            self::OPEN => 'soft-primary',
            self::PENDING => 'soft-warning',
            self::ASSIGNED => 'soft-info',
            self::ON_HOLD => 'soft-light',
            self::CLOSED => 'soft-success',
            self::COMPLETED => 'soft-success',
            self::NOT_STARTED => 'soft-warning',
            self::IN_PROGRESS => 'soft-info',
            self::UNDER_VERIFICATION => 'soft-warning',
            self::VERIFIED => 'soft-success',
        };
    }

    public function textColor(): string
    {
        return match ($this) {
            self::OPEN => 'text-primary',
            self::PENDING => 'text-warning',
            self::ASSIGNED => 'text-info',
            self::ON_HOLD => 'text-secondary',
            self::CLOSED => 'text-success',
            self::COMPLETED => 'text-success',
            self::NOT_STARTED => 'text-warning',
            self::IN_PROGRESS => 'text-info',
            self::UNDER_VERIFICATION => 'text-warning',
            self::VERIFIED => 'text-success',
        };
    }

}
