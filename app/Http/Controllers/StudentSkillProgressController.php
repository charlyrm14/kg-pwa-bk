<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StudentSkillProgress\UpdateStudentSkillProgressRequest;
use App\Domain\StudentSkillProgress\Services\UpdateStudentSkillProgressService;
use App\Models\StudentSkillProgress;

class StudentSkillProgressController extends Controller
{
    public function __construct(
        private UpdateStudentSkillProgressService $service
    ){}

    /**
     * Update the progress percentage of a student's skill.
     *
     * This endpoint allows administrators or instructors
     * to update the progress of a specific skill (0, 25, 50, 75, 100).
     *
     * On successful update:
     * - The skill progress is updated
     * - The parent category progress is recalculated
     * - The student may automatically advance to the next category
     *
     * @param UpdateStudentSkillProgressRequest $request
     * @param StudentSkillProgress $studentSkillProgress
     *
     * @throws DomainException Returns 422 if a business rule is violated.
     * @throws \Throwable Returns 500 if an unexpected error occurs.
     *
     * @return JsonResponse
     */
    public function update(UpdateStudentSkillProgressRequest $request, StudentSkillProgress $studentSkillProgress): JsonResponse
    {
        try {

            $this->service->execute(
                $studentSkillProgress,
                $request->validated()['progress_percentage']
            );

            return response()->json([
                'message' => 'Skill progress updated'
            ], 200);

        } catch (DomainException $e) {

            return response()->json(['message' => $e->getMessage()], 422);

        } catch(\Throwable $e) {

            Log::error('Error to update student skill progress: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error to update student skill progress',
            ], 500);
        }
    }
}

