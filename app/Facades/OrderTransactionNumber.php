<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\OrderTransactionNumberGenerator;

class OrderTransactionNumber extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OrderTransactionNumberGenerator::class;
    }
}
