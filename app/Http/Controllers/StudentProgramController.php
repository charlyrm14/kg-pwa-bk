<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\DTOs\StudentPrograms\EnrollStudentDTO;
use App\Domain\StudentPrograms\Services\EnrollStudentService;
use App\Http\Requests\StudentProgram\StoreStudentProgramRequest;

class StudentProgramController extends Controller
{
    public function __construct(
        private EnrollStudentService $enrollService
    ){}

    /**
     * Enrolls a student into a swimming program.
     *
     * This endpoint handles the assignment of a swimming program to a student.
     * It supports both:
     *
     * - Automatic enrollment (default placement), where the first category
     *   of the selected program is assigned based on the student's age.
     *
     * - Manual placement, where an admin specifies a category within the program,
     *   indicating that the student already has prior experience.
     *
    * Business rules validated during the process:
    * - The student must exist.
    * - The student must have a profile with a valid birthdate.
    * - The student's age must be within the allowed range of the selected program.
    * - The student must not have an active swimming program.
    * - If a category is provided, it must belong to the selected program.
    *
    * On success, a new student program is created along with the corresponding
    * category progress and skill progress records.
    *
    * @param  StoreStudentProgramRequest  $request  Validated request containing:
    *                                               - user_uuid
    *                                               - swim_program_id
    *                                               - swim_category_id (nullable)
    *
    * @return JsonResponse
    *
    * @response 201 {
    *   "message": "Enrollment created"
    * }
    *
    * @response 422 {
    *   "message": "Domain validation error message"
    * }
    *
    * @response 500 {
    *   "message": "Error to store student program"
    * }
    */
    public function store(StoreStudentProgramRequest $request): JsonResponse
    {
        try {

            $dto = EnrollStudentDTO::fromArray($request->validated());

            $this->enrollService->execute($dto);
            
            return response()->json(['message' => 'Enrollment created'], 201);

        } catch (DomainException $e) {

            return response()->json(['message' => $e->getMessage()], 422);

        } catch(\Throwable $e) {

            Log::error('Error to store student program: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error to store student program',
            ], 500);
        }
    }
}
