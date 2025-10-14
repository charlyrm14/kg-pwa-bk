<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Student\ProgressRequest;
use App\Http\Resources\Student\StudentProgressResource;
use App\Models\{
    User,
    StudentProgress,
    SwimCategory
};
use Illuminate\Support\Facades\Log;
use App\Services\Student\StudentProgressService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StudentProgressController extends Controller
{
    public function __construct(
        protected StudentProgressService $studentService
    ){}

    /**
     * The function `assignProgress` registers and validates progress for a student in a swim category,
     * handling errors and returning appropriate responses.
     * 
     * @param ProgressRequest request The `assignProgress` function you provided seems to handle the
     * assignment of progress for a student in a swim category. It performs several checks and
     * operations before registering the progress successfully.
     * 
     * @return JsonResponse A JSON response is being returned. If the operation is successful, a
     * response with a status code of 201 (Created) is returned, containing a success message and the
     * newly registered progress data in the response body. If there are any errors during the process,
     * appropriate error messages and status codes are returned to indicate the issue.
     */
    public function assignProgress(ProgressRequest $request): JsonResponse
    {        
        try {

            $user = User::getByUuid($request->user_uuid);

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            if ($user->role_id !== 3) {
                return response()->json(['message' => 'Invalid username, only students are allowed'], 400);
            }

            $this->studentService->validateAssignment($user->id, $request->swim_category_id);
            
            $newProgress = $this->studentService->registerProgress(
                $user->id,
                $request->swim_category_id,
                $request->progress_percentage
            );

            $currentTotalProgress = StudentProgress::getCurrentTotalProgress($user->id, $request->swim_category_id);
            $nextLevel = SwimCategory::nextSwimCategory($request->swim_category_id);

            $newProgress->current_total_progress = $currentTotalProgress;
            $newProgress->next_category_data = $nextLevel;

            return response()->json([
                'message' => 'Progress registered successfully',
                'data' => new StudentProgressResource($newProgress->load('user', 'swimCategory', 'progressStatus'))
            ], 201);

        } catch (HttpResponseException $e) {

            Log::error("Update category validation error: " . $e->getMessage());
            throw $e;

        } catch (\Throwable $e) {

            Log::error("Error assign progress: " . $e->getMessage());
            return response()->json(["error" => 'Error assign progress'], 500);
        }
    }
}
