<?php

namespace App\Enums;

enum UserOfflineVerification: string
{
    case PENDING = 'pending';
    case UNDER_REVIEW = 'under review';
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'soft-warning',
            self::UNDER_REVIEW => 'soft-info',
            self::VERIFIED => 'soft-success',
            self::REJECTED => 'soft-danger',
        };
    }

    public function textColor(): string
    {
        return match ($this) {
            self::PENDING => 'text-warning',
            self::UNDER_REVIEW => 'text-info',
            self::VERIFIED => 'text-success',
            self::REJECTED => 'text-danger',
        };
    }



}
