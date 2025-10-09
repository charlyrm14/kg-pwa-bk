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
        $type = $data['type'] ?? null;

        /** @var ContentStrategy $strategy */
        $strategy = match ($type) {
            'news' => new NewsStrategy(),
            'events' => new EventStrategy(),
            'tips' => new TipsStrategy(),
            'nutricion' => new NutritionStrategy(),
            default => throw new InvalidArgumentException("Unsupported content type {$type}")
        };

        return $strategy->create($data);
    }
}