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

    /**
     * The function getCurrentMonth returns the name of the current month in the specified language.
     * 
     * @param lang The `lang` parameter in the `getCurrentMonth` function is used to specify the
     * language in which you want the month name to be returned. By default, it is set to 'es' which
     * stands for Spanish. You can pass a different language code as an argument to get the month name
     * in
     * 
     * @return string The function `getCurrentMonth` is returning the current month in the specified
     * language. It uses the Carbon library to get the current date and then formats it to return the
     * full name of the current month in the specified language.
     */
    public static function getCurrentMonth($lang = 'es'): string
    {
        $now = Carbon::now();
        $now->locale($lang);

        return $now->translatedFormat('F');
    }
}