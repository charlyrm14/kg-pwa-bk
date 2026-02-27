<?php

declare(strict_types=1);

namespace App\Domain\StudentPrograms\Services;

use Carbon\Carbon;
use DomainException;
use App\Models\{
    User,
    SwimCategory,
    StudentProgram,
    SwimProgram
};


class BaseEnrollmentService
{
    /**
     * The function `validateUser` checks if a user exists, has a profile, and has a birthdate
     * registered before returning the user object.
     *
     * @param string userUuid The `validateUser` function takes a `userUuid` parameter, which is a
     * string representing the unique identifier of a user. This function is responsible for validating
     * the user based on the provided UUID.
     *
     * @return The `validateUser` function is returning the user object if all validation checks pass
     * successfully.
     */
    public function validateUser(string $userUuid): User
    {
        $user = User::with('profile')->firstWhere('uuid', $userUuid);

        if (!$user) {
            throw new DomainException('El alumno no existe.');
        }

        if (!$user->profile) {
            throw new DomainException('El alumno no tiene perfil registrado.');
        }

        if (!$user->profile->birthdate) {
            throw new DomainException(
                'El alumno debe tener fecha de nacimiento registrada para poder asignarlo a un programa.'
            );
        }

        return $user;
    }

    /**
     * The function `validateProgram` retrieves a SwimProgram with associated swim categories and
     * skills based on the provided program ID, and throws exceptions if the program does not exist or
     * has no categories configured.
     *
     * @param int programId The `validateProgram` function takes an integer parameter ``
     * which represents the ID of the swim program that needs to be validated. The function retrieves
     * the swim program with the specified ID along with its associated swim categories and skills.
     *
     * @return SwimProgram The `validateProgram` function is returning an instance of the `SwimProgram`
     * model after performing some validation checks.
     */
    public function validateProgram(int $programId): SwimProgram
    {
        $program = SwimProgram::with('swimCategories.skills')->find($programId);

        if (!$program) {
            throw new DomainException('El programa no existe.');
        }

        if ($program->swimCategories->isEmpty()) {
            throw new DomainException('El programa no tiene categorías configuradas.');
        }

        return $program;
    }

    /**
     * This PHP function validates a category ID against a SwimProgram object and returns the
     * corresponding SwimCategory if it exists.
     *
     * @param int categoryId The `categoryId` parameter is an integer representing the ID of the swim
     * category that needs to be validated within the `SwimProgram` object. The function
     * `validateCategory` takes this ID along with a `SwimProgram` object as parameters and returns the
     * corresponding `SwimCategory` object if
     * @param SwimProgram program The `validateCategory` function takes two parameters: ``,
     * which is an integer representing the ID of the category to validate, and ``, which is an
     * instance of the `SwimProgram` class. The function searches for a category within the program
     * based on the provided category ID and returns
     *
     * @return SwimCategory The `validateCategory` function is returning a `SwimCategory` object that
     * corresponds to the provided `` within the given `SwimProgram` object. If the category
     * with the specified ID is not found in the program's categories collection, a `DomainException`
     * is thrown with the message 'La categoría no pertenece al programa seleccionado.'
     */
    public function validateCategory(int $categoryId, SwimProgram $program): SwimCategory
    {
        $category = $program->swimCategories->firstWhere('id', $categoryId);
        
        if (!$category) {
            throw new DomainException(
                'La categoría no pertenece al programa seleccionado.'
            );
        }

        return $category;
    }

    /**
     * The function `validateNoActiveProgram` checks if a student with a given user ID already has an
     * active program and throws an exception if they do.
     *
     * @param int userId The `validateNoActiveProgram` function takes a parameter `` of type
     * integer. This function is used to check if a student with the given user ID already has an
     * active program. If an active program is found for the student, a `DomainException` is thrown
     * with the message 'El
     */
    public function validateNoActiveProgram(int $userId): void
    {
        $exists = StudentProgram::where('user_id', $userId)->whereNull('ended_at')->exists();

        if ($exists) {
            throw new DomainException(
                'El alumno ya tiene un programa activo.'
            );
        }
    }

    /**
     * The function `validateAge` checks if a user's age falls within the specified range for a swim
     * category.
     *
     * @param User user The `User` parameter represents a user object, which likely contains
     * information about a person, such as their profile details including birthdate.
     * @param SwimCategory category SwimCategory:
     */
    public function validateAge(User $user, SwimProgram $program): void
    {
        $age = Carbon::parse($user->profile->birthdate)->age;

        if ($age < $program->min_age || $age > $program->max_age) {
            throw new DomainException(
                'El alumno no cumple con el rango de edad permitido para la categoría seleccionada.'
            );
        }
    }

    /**
     * The function `createSkillProgress` creates skill progress records with a progress percentage of
     * 0 for each skill in a SwimCategory.
     *
     * @param categoryProgress  is an instance of a model representing the progress of
     * a category, which likely has a relationship with skills. The method `createSkillProgress` is
     * used to create skill progress records for each skill in a SwimCategory within the given
     * categoryProgress.
     * @param SwimCategory category The `createSkillProgress` function takes two parameters:
     */
    public function createSkillProgress($categoryProgress, SwimCategory $category): void
    {
        foreach ($category->skills as $skill) {
            $categoryProgress->skills()->create([
                'skill_id' => $skill->id,
                'progress_percentage' => 0,
            ]);
        }
    }
}
