<?php 

declare(strict_types=1);

namespace App\Services\Report;

use Illuminate\Support\Str;
use App\Services\Report\Strategies\{
    AttendanceReportStrategy
};
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportStrategyFactory
{
    /**
     * The function `make` returns an instance of a specific report strategy based on the provided
     * report type or throws an exception for an invalid report type.
     * 
     * @param reportType The `make` function is a factory method that creates an instance of a specific
     * report strategy based on the provided `reportType`. If the `reportType` is 'attendances', it
     * will return an instance of the `AttendanceReportStrategy`. If the `reportType` is not
     * recognized, it
     * 
     * @return The `make` function returns an instance of a specific report strategy based on the
     * provided ``. If the `` is 'attendances', it returns a new instance of the
     * `AttendanceReportStrategy`. If the `` does not match any specific case, it throws an
     * `HttpResponseException` with a JSON response indicating that the report type is invalid.
     */
    public function make($reportType)
    {
        return match ($reportType) {
            'attendances' => new AttendanceReportStrategy(),
            default => throw new HttpResponseException(
                response()->json(['message' => "Invalid report type"], 422)
            )
        };
    }
}