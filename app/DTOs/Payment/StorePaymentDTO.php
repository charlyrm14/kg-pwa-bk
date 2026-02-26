<?php

declare(strict_types=1);

namespace App\DTOs\Payment;

final class StorePaymentDTO
{
    public function __construct(
        public readonly ?string $userUuid,
        public readonly int $paymentTypeId,
        public readonly float $amount,
        public readonly string $paymentDate,
        public readonly ?int $paymentReferenceId,
        public readonly ?string $notes,
        public readonly int $registeredByUserId,
    ) {}

    public static function fromArray(array $data, int $registeredByUserId): self
    {
        return new self(
            userUuid: $data['user_uuid'] ?? null,
            paymentTypeId: (int) $data['payment_type_id'],
            amount: (float) $data['amount'],
            paymentDate: $data['payment_date'],
            paymentReferenceId: $data['payment_reference_id'] ?? null,
            notes: $data['notes'] ?? null,
            registeredByUserId: $registeredByUserId,
        );
    }
}