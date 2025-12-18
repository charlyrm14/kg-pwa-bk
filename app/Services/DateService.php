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

    /**
     * The function calculates the remaining time in hours or days from the current time to a given
     * date.
     * 
     * @param date The `remainingTime` function calculates the remaining time between the current time
     * and a given date. The function returns the remaining time in hours or days, depending on the
     * difference between the current time and the provided date.
     * 
     * @return ?string The `remainingTime` function returns a string indicating the remaining time
     * between the current time and the provided date. If the provided date is in the past, it returns
     * '0 horas'. If the remaining time is 24 hours or more, it returns the number of days remaining
     * followed by 'días'. Otherwise, it returns the number of hours remaining followed by 'horas'.
     */
    public static function remainingTime(?string $date): ?string
    {
        $remainingTime = null;

        if (!$date) return null;

        $now = Carbon::now();
        $start = Carbon::parse($date);

        if (!$start->isFuture()) {
            return '0 horas';
        }

        $hoursDiff = $now->diffInHours($start);

        return $hoursDiff >= 24
            ? (int) ceil($hoursDiff / 24) . ' días'
            : $hoursDiff . ' horas';
    }
}