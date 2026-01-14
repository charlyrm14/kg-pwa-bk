<?php

declare(strict_types=1);

namespace App\DTOs\Ranking\Events;

final class StoreRankingEventDTO 
{
    public function __construct(
        public readonly string $userUuid,
        public readonly string $triggerType,
        public readonly ?string $triggerId,
        public readonly string $eventDate,
        public readonly ?array $metadata
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            userUuid: $data['user_uuid'],
            triggerType: $data['trigger_type'],
            triggerId: $data['trigger_id'] ?? null,
            eventDate: $data['event_date'],
            metadata: $data['metadata'] ?? null
        );
    }
}