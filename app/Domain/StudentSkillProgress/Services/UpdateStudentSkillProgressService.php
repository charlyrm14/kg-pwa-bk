<?php

declare(strict_types=1);

namespace App\Domain\StudentSkillProgress\Services;

use DomainException;
use App\Models\{
    StudentCategoryProgress,
    StudentSkillProgress,
    SwimCategory
};
use Illuminate\Support\Facades\DB;

class UpdateStudentSkillProgressService
{
    /**
     * Update the progress percentage of a specific student skill.
     *
     * This method orchestrates the full update workflow:
     * - Validates whether the skill can be updated
     * - Persists the new progress value
     * - Recalculates the parent category progress
     * - Automatically advances the student to the next category if completed
     *
     * All operations are executed within a database transaction to ensure consistency.
     *
     * @param StudentSkillProgress $skill The student skill progress model instance.
     * @param int $progressPercentage The new progress value (0, 25, 50, 75, 100).
     *
     * @throws DomainException If the skill cannot be updated due to business rules.
     * @throws \Throwable If an unexpected error occurs during the transaction.
     *
     * @return void
     */
    public function execute(StudentSkillProgress $skillProgress, int $percentage): void
    {
        DB::transaction(function () use ($skillProgress, $percentage) {
            $this->validateUpdatable($skillProgress);
            $this->updateSkill($skillProgress, $percentage);
            $this->recalculateCategory($skillProgress->categoryProgress);
        });
    }

    /**
     * Validate whether the given student skill can be updated.
     *
     * Business rules:
     * - A skill cannot be updated if its parent category has already been completed.
     *
     * @param StudentSkillProgress $skill
     *
     * @throws DomainException If the skill belongs to a completed category.
     *
     * @return void
     */
    private function validateUpdatable(StudentSkillProgress $skill): void
    {
        // 1. No permitir actualizar skill si la categoría ya está completada
        if (!is_null($skill->categoryProgress->completed_at)) {
            throw new DomainException(
                'Cannot update a skill from a completed category.'
            );
        }
    }

    /**
     * Persist the new progress value for the given student skill.
     *
     * This method updates only the progress_percentage field.
     *
     * @param StudentSkillProgress $skill
     * @param int $progressPercentage
     *
     * @return void
     */
    private function updateSkill(StudentSkillProgress $skill, int $percentage): void
    {
        $skill->update([
            'progress_percentage' => $percentage,
            'completed_at' => $percentage === 100 ? now() : null,
        ]);
    }

    /**
     * Recalculate the overall progress of the parent category.
     *
     * The category progress is computed as the rounded average
     * of all related skill progress percentages.
     *
     * If all skills reach 100%, the category is marked as completed
     * and the student is automatically advanced to the next category.
     *
     * @param StudentCategoryProgress $category
     *
     * @return void
     */
    private function recalculateCategory(StudentCategoryProgress $category): void
    {
        $average = round((float) $category->skills()->avg('progress_percentage'));
        
        $allCompleted = !$category->skills()->where('progress_percentage', '<', 100)->exists();

        $category->update([
            'progress_percentage' => $average,
            'completed_at' => $allCompleted ? now() : null,
        ]);
        
        if ($allCompleted) {
            $this->advanceToNextCategory($category);
        }
    }

    /**
     * Automatically advance the student to the next category
     * within the same swim program.
     *
     * This method is triggered when the current category
     * reaches 100% completion.
     *
     * If no further categories exist, the program remains completed.
     *
     * @param StudentCategoryProgress $currentCategory
     *
     * @return void
     */
    private function advanceToNextCategory(StudentCategoryProgress $currentCategory): void
    {
        if ($currentCategory->completed_at === null) {
            return;
        }

        $studentProgram = $currentCategory->program;

        $nextCategory = SwimCategory::where('swim_program_id', $studentProgram->swim_program_id)
            ->where('order', '>', $currentCategory->swimCategory->order)
            ->orderBy('order')
            ->first();

        if (! $nextCategory) {
            return; // Program finished
        }

        // Prevent duplicate creation
        $alreadyExists = $studentProgram->categories()
            ->where('swim_category_id', $nextCategory->id)
            ->exists();

        if ($alreadyExists) {
            return;
        }

        $newCategoryProgress = $studentProgram->categories()->create([
            'swim_category_id' => $nextCategory->id,
            'progress_percentage' => 0,
            'started_at' => now(),
        ]);

        foreach ($nextCategory->skills as $skill) {
            $newCategoryProgress->skills()->create([
                'skill_id' => $skill->id,
                'progress_percentage' => 0,
            ]);
        }
    }
}
