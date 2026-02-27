<?php

declare(strict_types=1);

namespace App\Domain\StudentPrograms\Interfaces;

use App\DTOs\StudentPrograms\EnrollStudentDTO;

interface EnrollmentStrategy
{
    public function enroll(EnrollStudentDTO $dto): void;
}
