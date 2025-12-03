<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;

class DateService {

    /**
     * This PHP function calculates the age based on a given date of birth.
     * 
     * @param string date The `calculateAge` function takes a string parameter `` which represents
     * the birthdate of a person. If no date is provided, it defaults to '1990-01-01'. The function
     * calculates the age of the person based on the provided birthdate or the default birthdate if
     * none
     * 
     * @return int The function `calculateAge` is returning the age calculated based on the provided
     * date or the default date '1990-01-01'. It uses the Carbon library to parse the date and
     * calculate the difference in years between the parsed date and the current date. The result is
     * then cast to an integer before being returned.
     */
    public static function calculateAge(string $date = '1990-01-01'): int
    {
        $format_birthdate = Carbon::parse($date);

        return (int) $format_birthdate->diffInYears(Carbon::today());
    }
}