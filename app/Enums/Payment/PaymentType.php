<?php

declare(strict_types=1);

namespace App\Enums\Payment;

enum PaymentType: int
{
    case VISIT = 1;
    case MONTHLY = 2;
    case ANNUAL = 3;
}