<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DomainException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\DTOs\StudentPrograms\EnrollStudentDTO;
use App\Domain\Users\Services\ResolverUserService;
use App\Domain\StudentPrograms\Services\EnrollStudentService;
use App\Http\Requests\StudentProgram\StoreStudentProgramRequest;
use App\Http\Resources\StudentProgram\ShowStudentProgramResource;

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

    /**
     * Display the swimming program progress for a student.
     *
     * This endpoint allows retrieving the swimming progress associated with a user.
     * The user can be resolved in two ways:
     *
     * - If a UUID is provided, the system resolves the target user and validates
     *   authorization through the corresponding policy ability.
     * - If no UUID is provided, the authenticated user is used.
     *
     * The response includes:
     * - User basic information
     * - Current level
     * - Next level
     * - Progression history
     * - Program information
     * - Skills progress
     *
     * Results are cached temporarily to reduce database queries.
     *
     * @param Request $request The current HTTP request instance.
     * @param string|null $uuid Optional UUID used by administrators to fetch
     *                          another student's progress.
     *
     * @return JsonResponse
     */
    public function show(Request $request, ?string $uuid = null): JsonResponse
    {
        try {

            $user = ResolverUserService::resolve($request, $uuid, 'viewStudentProgram');

            $cacheKey = "student_program_progress_{$user->id}";

            $userProgram = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
                return $user->studentPrograms()
                    ->with([
                        'user',
                        'categories.swimCategory',
                        'categories.skills.skill',
                        'program'
                    ])
                    ->first();
            });
            
            if(!$userProgram) {
                return response()->json(['message' => 'User without progress'], 404);
            }
                        
            return response()->json([
                'data' => new ShowStudentProgramResource($userProgram)
            ], 200);
            
        } catch(\Throwable $e) {

            Log::error('Error to get student program progress: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error to get student program progress',
            ], 500);
        }
    }
}
