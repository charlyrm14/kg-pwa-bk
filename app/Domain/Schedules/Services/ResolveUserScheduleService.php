<?php

declare(strict_types=1);

namespace App\Domain\Schedules\Services;

use Carbon\Carbon;
use DomainException;
use App\Models\UserSchedule;

class ResolveUserScheduleService
{
    /**
     * The function `handle` retrieves a user's schedule based on the user ID and date, defaulting to
     * the current date if no date is provided.
     *
     * @param int userId The `userId` parameter is an integer representing the ID of the user for whom
     * you want to retrieve the schedule.
     * @param date The `date` parameter in the `handle` function is a nullable string that represents a
     * date in the format 'Y-m-d'. If a date is provided, it will be used to determine the day of the
     * week for which the user's schedule needs to be retrieved. If no date is provided
     *
     * @return UserSchedule a `UserSchedule` object.
     */
    public function handle(int $userId, ?string $date): UserSchedule
    {
        $resolvedDate = $date ? Carbon::createFromFormat('Y-m-d', $date) : now();
        $dayOfWeek = $resolvedDate->dayOfWeekIso;
        
        $schedule = UserSchedule::query()
            ->where([
                ['user_id', $userId],
                ['day_id', $dayOfWeek]
            ])
            ->first();

        if (!$schedule) {
            throw new DomainException(
                'User has no schedules assigned for this day.'
            );
        }

        return $schedule;
    }
}
