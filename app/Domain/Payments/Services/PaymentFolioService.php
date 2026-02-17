<?php

declare(strict_types=1);

namespace App\Domain\Payments\Services;

use App\Models\Payment;

class PaymentFolioService
{
    private const PREFIX = 'PAY';

    /**
     * The function assigns a folio to a payment if it does not already have one.
     *
     * @param Payment payment The `handle` function takes a `Payment` object as a parameter. The
     * function checks if the `folio` property of the `Payment` object is already set. If it is not
     * set, the function generates a new `folio` using the `build` method and updates the `folio`
     *
     * @return void If the condition `->folio` is true, then the function will return without
     * executing the rest of the code.
     */
    public function handle(Payment $payment): void
    {
        if ($payment->folio) {
            return;
        }

        $folio = $this->build($payment->id);

        $payment->updateQuietly([
            'folio' => $folio
        ]);
    }

    /**
     * The function "build" takes an integer ID and returns a string formatted with a prefix and the ID
     * padded to six digits.
     *
     * @param int id The `id` parameter in the `build` function is an integer value used to generate a
     * formatted string.
     *
     * @return string The function `build` takes an integer `` as a parameter and returns a string
     * formatted as `PREFIX-` where `` is padded with zeros to a total length of 6 digits.
     */
    private function build(int $id): string
    {
        return sprintf('%s-%06d', self::PREFIX, $id);
    }
}
