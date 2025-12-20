<?php

declare(strict_types=1);

namespace App\Services\Content;

use App\Models\Content;
use InvalidArgumentException;
use App\Services\Content\Strategies\{
    NewsStrategy,
    EventStrategy,
    NutritionStrategy,
    TipsStrategy
};
use App\Services\Content\Interfaces\ContentStrategy;

class ContentManager {

    public function handle(array $data): ?Content
    {
        $contentTypeId = $data['content_type_id'] ?? null;

        /** @var ContentStrategy $strategy */
        $strategy = match ($contentTypeId) {
            1 => new NewsStrategy(),
            2 => new EventStrategy(),
            3 => new TipsStrategy(),
            4 => new NutritionStrategy(),
            default => throw new InvalidArgumentException("Unsupported content type {$contentTypeId}")
        };

        return $strategy->create($data);
    }
}