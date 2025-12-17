<?php

declare(strict_types=1);

namespace App\Services\Student;

use Carbon\Carbon;
use App\Models\{ StudentProgress, SwimCategory, User};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class StudentProgressService
{
    private const STATUS_ACTIVE = 1;
    private const STATUS_COMPLETED = 2;
    private const MAX_PROGRESS = 100;

    /**
     * This PHP function retrieves and formats data related to the current level progress of a user in
     * a swim category.
     * 
     * @param User user The `currentLevelData` function takes a `User` object as a parameter. It
     * retrieves the current level data for the user based on their student progress. The function
     * calculates the total progress for the current level, retrieves the completion date of the
     * current level, and loads the skills associated with the current
     * 
     * @return ?array An array containing the following data is being returned:
     */
    public function currentLevelData(User $user): ?array
    {
        $currentLevelId = $user->studentProgress->max('swim_category_id');
        
        $category = SwimCategory::with('categorySkills.skill')->firstWhere('id', $currentLevelId);

        $totalProgressCurrentLevel = $user->studentProgress->where('swim_category_id', $currentLevelId)->sum('progress_percentage');

        $completedLevelDate = $user->studentProgress
            ->where('swim_category_id', $currentLevelId)
            ->whereNotNull('end_date')->first();

        return [
            'category_name' => optional($category)->name,
            'category_description' => optional($category)->description,
            'total_progress' => $totalProgressCurrentLevel,
            'total_progress_formatted' => "{$totalProgressCurrentLevel}%",
            'completed_level_date' => optional($completedLevelDate)->end_date,
            'category_skills' => $category ? $category->categorySkills->map(function($item) {
                return [
                    'skill' => $item->skill->description
                ];
            }) : null
        ];
    }

    /**
     * This PHP function retrieves data for the next level of a user's swim category progression.
     * 
     * @param User user The `nextLevelData` function takes a `User` object as a parameter. It retrieves
     * the current level ID of the user's student progress, then determines the next swim category
     * based on the current level ID using the `nextSwimCategory` method from the `SwimCategory` model.
     * 
     * @return ?array An array is being returned with the following keys and values:
     * - 'category_name': The name of the next swim category (or null if not found)
     * - 'category_description': The description of the next swim category (or null if not found)
     * - 'total_progress': null
     * - 'total_progress_formatted': null
     * - 'completed_level_date': null
     * - 'category_skills': null
     */
    public function nextLevelData(User $user): ?array
    {   
        $currentLevelId = $user->studentProgress->max('swim_category_id');

        $nextCategory = $currentLevelId 
            ? SwimCategory::nextSwimCategory($currentLevelId)
            : SwimCategory::firstWhere('id', 1);

        $nextCategory->load('categorySkills.skill');

        return [
            'category_name' => optional($nextCategory)->name,
            'category_description' => optional($nextCategory)->description,
            'category_skills' => $nextCategory->categorySkills->map(function($item) {
                return [
                    'skill' => $item->skill->description
                ];
            })
        ];
    }

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