<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    // Is line ko 'completed' karein kyunki aapne tinker se yahi set kiya hai
    case COMPLETED = 'completed'; 
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
    case CANCELLED = 'cancelled';
    case UN_PAID = 'un paid';

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'soft-warning',
            self::COMPLETED => 'soft-success',
            self::FAILED => 'soft-danger',
            self::REFUNDED => 'soft-info',
            self::CANCELLED => 'soft-danger',
            self::UN_PAID => 'soft-warning',
        };
    }
}