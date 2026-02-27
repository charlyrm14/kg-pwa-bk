<?php

declare(strict_types=1);

namespace App\Domain\StudentPrograms\Services;

use App\Models\{
    StudentProgram,
    SwimProgram,
    SwimCategory
};

class PlacementEnrollmentService
{
    /**
     * The function `handleCategoryPlacement` assigns swim categories to a student program based on the
     * selected category's level order.
     *
     * @param StudentProgram studentProgram The `handleCategoryPlacement` function you provided seems
     * to handle the placement of swim categories for a student in a swim program. It creates category
     * progress records for the student based on the selected category.
     * @param SwimProgram program The `handleCategoryPlacement` function you provided seems to handle
     * the placement of swim categories for a student in a swim program. It creates category progress
     * records for the student based on the selected category.
     * @param SwimCategory selectedCategory The `handleCategoryPlacement` function you provided seems
     * to handle the placement of swim categories for a student in a swim program. It creates category
     * progress records for the student based on the selected category.
     */
    public function handleCategoryPlacement(
        StudentProgram $studentProgram,
        SwimProgram $program,
        SwimCategory $selectedCategory
    )
    {
        $categories = $program->swimCategories->sortBy('level_order');

        foreach ($categories as $category) {

            if ($category->level_order < $selectedCategory->level_order) {

                $studentProgram->categories()->create([
                    'swim_category_id' => $category->id,
                    'progress_percentage' => 100,
                    'started_at' => now(),
                    'completed_at' => now(),
                ]);

            } elseif ($category->id === $selectedCategory->id) {

                $categoryProgress = $studentProgram->categories()->create([
                    'swim_category_id' => $category->id,
                    'progress_percentage' => 0,
                    'started_at' => now(),
                ]);

                $this->createSkillProgress($categoryProgress, $category);
            }
        }
    }

    /**
     * The function `createSkillProgress` creates skill progress records with a progress percentage of
     * 0 for each skill in a SwimCategory.
     *
     * @param categoryProgress  is an instance of a model representing the progress of
     * a specific category. It likely has a relationship with the skills belonging to that category.
     * @param SwimCategory category `` is an instance of the `SwimCategory` class, which
     * likely represents a category of swimming skills. It seems to have a property `skills` that holds
     * a collection of skills related to that category. The function `createSkillProgress` takes two
     * parameters: ``,
     */
    private function createSkillProgress($categoryProgress, SwimCategory $category): void
    {
        foreach ($category->skills as $skill) {

            $categoryProgress->skills()->create([
                'skill_id' => $skill->id,
                'progress_percentage' => 0,
            ]);
        }
    }
}