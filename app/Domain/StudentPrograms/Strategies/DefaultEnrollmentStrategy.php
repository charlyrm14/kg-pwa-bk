<?php

declare(strict_types=1);

namespace App\Domain\StudentPrograms\Strategies;

use App\Models\StudentProgram;
use Illuminate\Support\Facades\DB;
use App\DTOs\StudentPrograms\EnrollStudentDTO;
use App\Domain\StudentPrograms\Interfaces\EnrollmentStrategy;
use App\Domain\StudentPrograms\Services\BaseEnrollmentService;

class DefaultEnrollmentStrategy implements EnrollmentStrategy
{
    public function __construct(
        private BaseEnrollmentService $baseEnrollmentService
    ){}

    public function enroll(EnrollStudentDTO $dto): void
    {
        DB::transaction(function () use ($dto) {

            $user = $this->baseEnrollmentService->validateUser($dto->userUuid);
            $program = $this->baseEnrollmentService->validateProgram($dto->swimProgramId);

            $this->baseEnrollmentService->validateNoActiveProgram($user->id);

            $firstCategory = $program->swimCategories->sortBy('level_order')->first();

            $this->baseEnrollmentService->validateAge($user, $program);
            
            $studentProgram = StudentProgram::create([
                'user_id' => $user->id,
                'swim_program_id' => $program->id,
                'started_at' => now(),
            ]);

            $categoryProgress = $studentProgram->categories()->create([
                'swim_category_id' => $firstCategory->id,
                'progress_percentage' => 0,
                'started_at' => now(),
            ]);

            $this->baseEnrollmentService->createSkillProgress($categoryProgress, $firstCategory);
        });
    }
}
