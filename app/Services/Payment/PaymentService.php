<?php

declare(strict_types=1);

namespace App\Services\Payment;

use Carbon\Carbon;
use App\Enums\Payment\PaymentType;

class PaymentService
{
    /**
     * The function `calculateCoverageDate` returns a Carbon date based on the payment type ID
     * provided.
     * 
     * @param int paymentTypeId The `paymentTypeId` parameter is an integer value that represents the
     * type of payment coverage. In the provided code snippet, it is used in a `match` expression to
     * determine the payment coverage duration based on the given payment type. The function returns a
     * `Carbon` instance representing the calculated payment coverage date
     * 
     * @return ?Carbon The `calculateCoverageDate` function returns a Carbon instance based on the
     * provided ``. If the `` is 1, it returns the current date plus one
     * month. If the `` is 2, it returns the current date plus one year. If the
     * `` is 3, it returns the current date. If the `` does
     */
    public function calculateCoverageDate(int $paymentTypeId, string $date): ?Carbon
    {
        $coverageDate = Carbon::createFromFormat('Y-m-d', $date);

        return match($paymentTypeId) {
            PaymentType::MONTHLY->value => $coverageDate->copy()->addMonth(),
            PaymentType::ANNUAL->value => $coverageDate->copy()->addYear(),
            PaymentType::VISIT->value => $coverageDate,
            PaymentType::FAMILY->value => $coverageDate->copy()->addMonth(),
            default => Carbon::now(),
        };
    }
}