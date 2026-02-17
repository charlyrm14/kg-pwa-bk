<?php

namespace App\Observers;

use App\Models\Payment;
use App\Domain\Payments\Services\PaymentFolioService;

class PaymentObserver
{
    public function __construct(
        private PaymentFolioService $folio
    ){}

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $this->folio->handle($payment);
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
