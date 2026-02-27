<?php

declare(strict_types=1);

namespace App\Domain\StudentPrograms\Factories;

use App\Domain\StudentPrograms\Interfaces\EnrollmentStrategy;
use App\Domain\StudentPrograms\Strategies\DefaultEnrollmentStrategy;
use App\Domain\StudentPrograms\Strategies\PlacementEnrollmentStrategy;

class EnrollmentStrategyFactory
{
    public static function make(?int $categoryId, int $programId): EnrollmentStrategy
    {
        if ($categoryId) {
            return app(PlacementEnrollmentStrategy::class);
        }

        return app(DefaultEnrollmentStrategy::class);
    }
}
