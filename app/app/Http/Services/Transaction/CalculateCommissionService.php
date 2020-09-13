<?php

namespace App\Http\Services\Transaction;

class CalculateCommissionService
{
    public function __invoke(float $amount): float
    {
        return number_format($amount * (float) config('logic.commission_rate')/100, 2);
    }
}
