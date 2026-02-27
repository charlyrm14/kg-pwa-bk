<?php

declare(strict_types=1);

namespace App\Domain\StudentPrograms\Services;

use App\Domain\StudentPrograms\Factories\EnrollmentStrategyFactory;
use App\DTOs\StudentPrograms\EnrollStudentDTO;

class EnrollStudentService
{
    public function execute(EnrollStudentDTO $dto): void
    {
        $strategy = EnrollmentStrategyFactory::make(
            $dto->swimCategoryId,
            $dto->swimProgramId
        );

        $strategy->enroll($dto);
    }
}
