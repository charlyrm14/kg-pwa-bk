<?php

declare(strict_types=1);

namespace App\Services\Student;

use Carbon\Carbon;
use App\Models\{ StudentProgress, SwimCategory };
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class StudentProgressService
{
    private const STATUS_ACTIVE = 1;
    private const STATUS_COMPLETED = 2;
    private const MAX_PROGRESS = 100;

    /**
     * The function `validateAssignment` checks if a student can be assigned to a specific category
     * based on their progress and the completion status of previous categories.
     * 
     * @param int userId The `userId` parameter in the `validateAssignment` function represents the
     * unique identifier of the user for whom the assignment validation is being performed. This
     * parameter is used to retrieve the current progress of the user in a specific category and to
     * check if the previous category has been completed before assigning a new category.
     * @param int categoryId The `categoryId` parameter in the `validateAssignment` function represents
     * the ID of the swim category that is being validated for assignment to a user. This function is
     * responsible for checking if the user has made sufficient progress in the current category and if
     * the previous category (if applicable) has been completed before assigning
     */
    public function validateAssignment(int $userId, int $categoryToAssignId): void
    {
        $currentProgress = StudentProgress::getCurrentTotalProgress($userId, $categoryToAssignId);

        if($currentProgress >= self::MAX_PROGRESS) {
            $nextCategory = SwimCategory::nextSwimCategory($categoryToAssignId);
            throw new HttpResponseException(
                response()->json([
                    'message' => "This category has been completed. The next category it's " . ($nextCategory ? $nextCategory->name : 'N/A')
                ], 422)
            );
        }

        if($categoryToAssignId > 1) {
            $previousCategoryId = $categoryToAssignId - 1;
            
            $previousCategoryProgress = StudentProgress::getCurrentTotalProgress($userId, $previousCategoryId);

            if($previousCategoryProgress < self::MAX_PROGRESS) {
                $previousCategory = SwimCategory::firstWhere('id',$previousCategoryId);
                
                if($previousCategory) {
                    throw new HttpResponseException(
                        response()->json([
                            'message' => "This category cannot be assigned. The category " . ($previousCategory ?  $previousCategory->name : "N/A") . " must be 100% complete."
                        ], 422)
                    );
                }
            }
        }
    }

    /**
     * The function `registerProgress` registers a new progress for a student in a specific category,
     * ensuring the total progress does not exceed the maximum allowed percentage.
     * 
     * @param int userId The `userId` parameter in the `registerProgress` function represents the
     * unique identifier of the user for whom you want to register progress. This parameter is used to
     * associate the progress with a specific user in the system.
     * @param int categoryId The `categoryId` parameter in the `registerProgress` function represents
     * the ID of the category for which the progress is being registered. This could be used to track
     * the progress of a student in a specific category or subject area, such as swimming techniques,
     * math skills, or language proficiency.
     * @param int newPercentage The `newPercentage` parameter in the `registerProgress` function
     * represents the additional progress percentage that the user has achieved in a specific category.
     * This value is added to the current progress percentage for that category to calculate the total
     * progress.
     * 
     * @return ?StudentProgress The `registerProgress` function returns an instance of
     * `StudentProgress` after creating a new progress record for a user in a specific category.
     */
    public function registerProgress(int $userId, int $categoryToAssignId, int $newPercentage): ?StudentProgress
    {
        $currentProgress = StudentProgress::getCurrentTotalProgress($userId, $categoryToAssignId);
        $totalProgress = $currentProgress + $newPercentage;

        if($totalProgress > self::MAX_PROGRESS) {
            throw new HttpResponseException(
                response()->json([
                    'message' => "The new progress exceeds 100%. the current progress is {$currentProgress}"
                ], 422)
            );
        }

        $isComplete = ($totalProgress === self::MAX_PROGRESS);

        return DB::transaction(function () use($userId, $categoryToAssignId, $newPercentage, $isComplete){
            
            $progress = StudentProgress::create([
                'user_id' => $userId,
                'swim_category_id' => $categoryToAssignId,
                'progress_status_id' => $isComplete ? self::STATUS_COMPLETED : self::STATUS_ACTIVE,
                'progress_percentage' => $newPercentage,
                'start_date' => Carbon::now()->toDateString(),
                'end_date' => $isComplete ? Carbon::now()->toDateString() : null
            ]);

            if($isComplete) {
                // Disparar notificación a usuario de 'nivel completado'
            }

            return $progress;
        });
    }
}