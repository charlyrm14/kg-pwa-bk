<?php

declare(strict_types=1);

namespace App\Domain\StudentPrograms\Strategies;

use DomainException;
use App\Models\StudentProgram;
use Illuminate\Support\Facades\DB;
use App\DTOs\StudentPrograms\EnrollStudentDTO;
use App\Domain\StudentPrograms\Interfaces\EnrollmentStrategy;
use App\Domain\StudentPrograms\Services\BaseEnrollmentService;
use App\Domain\StudentPrograms\Services\PlacementEnrollmentService;

class PlacementEnrollmentStrategy implements EnrollmentStrategy
{
    public function __construct(
        private BaseEnrollmentService $baseEnrollmentService,
        private PlacementEnrollmentService $placementService
    ){}

    /**
     * The `enroll` function in PHP enrolls a student in a swim program after performing various
     * validations and handling category placement.
     *
     * @param EnrollStudentDTO dto
     */
    public function enroll(EnrollStudentDTO $dto): void
    {
        DB::transaction(function () use ($dto) {

            $user = $this->baseEnrollmentService->validateUser($dto->userUuid);
            $program = $this->baseEnrollmentService->validateProgram($dto->swimProgramId);
            $category = $this->baseEnrollmentService->validateCategory($dto->swimCategoryId, $program);

            if ($category->swim_program_id !== $program->id) {
                throw new DomainException(
                    'The selected category does not belong to the selected program.'
                );
            }
            
            $this->baseEnrollmentService->validateNoActiveProgram($user->id);
            $this->baseEnrollmentService->validateAge($user, $program);

            $studentProgram = StudentProgram::create([
                'user_id' => $user->id,
                'swim_program_id' => $program->id,
                'started_at' => now(),
            ]);
            
            $this->placementService->handleCategoryPlacement($studentProgram, $program, $category);
        });
    }
}
