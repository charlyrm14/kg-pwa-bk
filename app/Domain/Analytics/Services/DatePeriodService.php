<?php

declare(strict_types=1);

namespace App\Domain\Analytics\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DatePeriodService
{
    /**
     * The function `resolvePeriod` takes a request object and returns an array containing the start
     * and end dates of a specified month or the current month along with a cache key.
     *
     * @param Request request The `resolvePeriod` function takes a `Request` object as a parameter.
     * This object is used to retrieve input data, such as the 'month' parameter, from an HTTP request.
     *
     * @return array An array is being returned containing the start and end dates of the period based
     * on the request input. If the 'month' parameter is provided in the request, the function returns
     * the start and end dates of that month along with the 'month' value as a cache key. If the
     * 'month' parameter is not provided, the function returns the start of the current month and the
     * end of the current
     */
    public function resolvePeriod(Request $request): array
    {
        if($request->filled('month')) {
            $date = Carbon::createFromFormat('Y-m', $request->month);

            return [
                $date->copy()->startOfMonth()->startOfDay(),
                $date->copy()->endOfMonth()->endOfDay(),
                $request->month // cache key
            ];
        }

        return [
            now()->startOfMonth()->startOfDay(),
            now()->endOfDay(),
            now()->format('Y-m-d') // cache key
        ];
    }

    
    /**
     * This PHP function resolves the start and end dates of an annual period based on the provided
     * year in the request, or defaults to the current year if no year is provided.
     *
     * @param Request request The `resolveAnnualPeriod` function takes a `Request` object as a
     * parameter. This function checks if the request contains a 'year' parameter. If the 'year'
     * parameter is present, it creates a Carbon date object based on the provided year and returns an
     * array with the start and end dates
     *
     * @return array An array containing the start and end dates of the annual period based on the
     * input year provided in the request, or the current year if no year is provided. The dates are
     * formatted as 'Y-m-d'.
     */
    public function resolveAnnualPeriod(Request $request): array
    {
        if($request->filled('year')) {
            $date = Carbon::createFromFormat('Y', $request->year);
            
            return [
                $date->copy()->startOfYear()->startOfDay(),
                $date->copy()->endOfYear()->endOfDay(),
                $request->year
            ];
        }

        return [
            now()->startOfYear()->startOfDay(),
            now()->endOfMonth()->endOfDay(),
            now()->format('Y')
        ];
    }
}
