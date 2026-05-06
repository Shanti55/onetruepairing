<?php

namespace App\Services;

class RegistrationFeeService
{
    public function calculate(float $jobAmount): float
    {
        return round($jobAmount * 0.10, 2); // 10% of job value = EMD
    }

    public function platformFee(float $emd): float
    {
        return round($emd * 0.01, 2); // 1% of EMD = Platform Fee
    }
}