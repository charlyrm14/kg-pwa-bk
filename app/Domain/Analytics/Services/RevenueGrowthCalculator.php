<?php

declare(strict_types=1);

namespace App\Domain\Analytics\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RevenueGrowthCalculator
{
    /**
     * The function `fillMonths` generates a collection of payment amounts for each month up to the
     * current month or December of a given year.
     *
     * @param year The `year` parameter is a nullable string that represents the year for which you
     * want to fill the months with payment data. If the `year` is provided, the function will fill the
     * months from January to December of that year. If the `year` is not provided (null), it will
     * @param Collection payments The `fillMonths` function takes two parameters: `` and
     * ``. The `` parameter is an optional string representing the year for which the
     * months need to be filled. If `` is provided, it will fill months from January to December
     * of that year. If `
     *
     * @return Collection A collection of payment amounts for each month in the specified year or up to
     * the current month if no year is provided. If there is no payment amount for a specific month, it
     * defaults to 0.
     */
    public function fillMonths(?string $year, Collection $payments): Collection
    {
        $currentMonth = $year ? 12 : now()->month;
        
        return collect(range(1, $currentMonth))
            ->mapWithKeys(function ($month) use ($payments) {
                return [
                    $month => $payments[$month] ?? 0
                ];
            });
    }

    /**
     * This PHP function calculates the base amount from a collection of months.
     *
     * @param Collection months It looks like the code snippet you provided is a PHP function
     * `calculateBaseAmount` that takes a `Collection` of months as input and calculates a base amount
     * based on certain conditions.
     *
     * @return int The `calculateBaseAmount` function returns an integer value. If the collection of
     * months is empty, it returns 0. If the second element in the collection is 0, it returns the
     * first positive value in the collection or 0 if none is found. Otherwise, it returns the second
     * element in the collection as an integer.
     */
    public function calculateBaseAmount(Collection $months): int
    {
        if($months->isEmpty()){
            return 0;
        }

        $amount = $months[1];

        if($amount == 0) {
            return $months->first(fn ($value) => $value > 0) ?? 0;
        }

        return (int) $amount;
    }

    /**
     * The function calculates the percentage of each amount in relation to a base amount for a given
     * set of months.
     *
     * @param months The `calculatePercentages` function takes two parameters: `` and
     * ``.
     * @param baseAmount The `baseAmount` parameter in the `calculatePercentages` function represents
     * the base amount against which the percentages will be calculated for each month. It is used to
     * determine the percentage of each amount in relation to the base amount.
     *
     * @return An array of month labels and their corresponding percentages calculated based on the
     * amounts provided for each month and the base amount.
     */
    public function calculatePercentages(Collection $months, int $baseAmount, string $year): Collection
    {
        return $months->map(function ($amount, $month) use ($baseAmount, $year) {
            $percentage = $baseAmount > 0
                ? round(($amount / $baseAmount) * 100)
                : 0;

            return [
                'month' => $this->getMonthLabel($month) . ' ' . $year,
                'percentage' => $percentage
            ];
        })->values();
    }

    /**
     * The function `getMonthLabel` returns the short name of a month in Spanish based on the provided
     * month number.
     *
     * @param int month The `getMonthLabel` function takes an integer parameter `` representing
     * the month number (1 for January, 2 for February, and so on). The function uses the Carbon
     * library to create a date object with the specified month and then retrieves the short name of
     * the month in Spanish locale.
     *
     * @return string The function `getMonthLabel` returns the short name of the month in Spanish for
     * the given month number.
     */
    private function getMonthLabel(int $month): string
    {
        return Str::ucFirst(Carbon::create()->month($month)->locale('es')->shortMonthName);
    }
}
