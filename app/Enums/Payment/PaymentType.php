<?php

declare(strict_types=1);

namespace App\Enums\Payment;

enum PaymentType: int
{
    case MONTHLY = 1;
    case ANNUAL  = 2;
    case VISIT   = 3;
    case FAMILY  = 4;
}