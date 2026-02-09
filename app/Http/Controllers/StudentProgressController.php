<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Student\ProgressRequest;
use App\Http\Resources\Student\{
    LogStudentProgressResource,
    StudentProgressResource
};
use App\Models\{
    User,
    StudentProgress,
    SwimCategory
};
use Illuminate\Support\Facades\Log;
use App\Services\Student\StudentProgressService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\{
    Request,
    JsonResponse
};
use App\Services\UserService;

class StudentProgressController extends Controller
{
    public function __construct(
        protected StudentProgressService $studentService
    ){}

    /**
     * This PHP function retrieves and returns progress data for a user identified by their UUID.
     * 
     * @param string uuid The `dataProgress` function takes a UUID (Universally Unique Identifier) as a
     * parameter. This UUID is used to retrieve a user's data and progress information. If the user
     * with the provided UUID is found, their progress data is fetched, including their current level,
     * next level, and progression history
     * 
     * @return JsonResponse A JsonResponse is being returned. If the user is not found, a JSON response
     * with a message 'User not found' and status code 404 is returned. If there is an error during the
     * process, a JSON response with an error message 'Error to get progress user data' and status code
     * 500 is returned. Otherwise, a JSON response with the user's progress data in the 'data'
     */
    public function dataProgress(Request $request, ?string $uuid = null): JsonResponse
    {
        try {

            $user = UserService::resolveUser($request, $uuid, 'viewProgress');

            $user->load('studentProgress');

            $currentLevel = $this->studentService->currentLevelData($user);
            $nextLevel = $this->studentService->nextLevelData($user);
            $progression = $user->progressionByCategory();

            $user->current_level = $currentLevel;
            $user->next_level = $nextLevel;
            $user->progression_history = $progression;
            
            return response()->json([
                'data' => new LogStudentProgressResource($user)
            ], 200);

        } catch (HttpResponseException $e) {

            Log::error("Error to get progress user data validation: " . $e->getMessage());
            throw $e;

        }  catch (\Throwable $e) {

            Log::error("Error to get progress user data: " . $e->getMessage());
            return response()->json(["error" => 'Error to get progress user data'], 500);
        }
    }

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
