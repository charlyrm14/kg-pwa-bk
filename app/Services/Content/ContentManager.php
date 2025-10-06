<?php

declare(strict_types=1);

namespace App\Services\Content;

use App\Models\Content;
use InvalidArgumentException;
use App\Services\Content\Strategies\{
    EventStrategy
};
use App\Services\Content\Interfaces\ContentStrategy;

class ContentManager {

    public function handle(array $data): ?Content
    {
        $type = $data['type'] ?? null;

        /** @var ContentStrategy $strategy */
        $strategy = match ($type) {
            'events' => new EventStrategy(),
            default => throw new InvalidArgumentException("Unsupported content type {$type}")
        };

        return $strategy->create($data);
    }
}