<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{
    Payment,
    UserAttendance
};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\QueryFilter\Pipes\DateRange;
use Illuminate\Support\Facades\Cache;
use App\Domain\Analytics\Services\DatePeriodService;
use App\QueryFilter\Analytics\Attendances\AttendanceSummary;
use App\QueryFilter\Analytics\Payments\PaymentDistribution;



class AnalyticController extends Controller
{
    private const CACHE_TIME = 5;

    public function __construct(
        private DatePeriodService $periodService
    ){}

    /**
     * This PHP function retrieves payment analytics data within a specified period and caches the
     * results for improved performance.
     *
     * @param Request request The `paymentsDistribution` function takes a `Request` object as a
     * parameter. This object likely contains information about the request being made to the server,
     * such as query parameters, headers, and request body.
     *
     * @return JsonResponse The `paymentsDistribution` function returns a JSON response containing the
     * data retrieved from the cache or database based on the provided request parameters. The data
     * includes the total sum of `total_amount` from the payments within the specified date range and
     * the distribution of payments if available. If an error occurs during the process, it logs the
     * error message and returns a JSON response indicating the failure to retrieve payment analytics.
     */
    public function paymentsDistribution(Request $request): JsonResponse
    {
        try {

            [$from, $to, $cacheKeyPeriod] = $this->periodService->resolvePeriod($request);

            $cacheKey = "analytics:payments:distribution:{$cacheKeyPeriod}";

            $data = Cache::remember($cacheKey, now()->addMinutes(self::CACHE_TIME), function () use ($from, $to) {

                $query = Payment::query();

                $pipes = [
                    new DateRange($from, $to, 'payment_date'),
                    new PaymentDistribution()
                ];

                foreach ($pipes as $pipe) {
                    $query = $pipe->apply($query);
                }

                return $query->get();
            });

            if($data->isEmpty()) {
                return response()->json(['message' => 'Results not found'], 404);
            }

            return response()->json([
                'data' => [
                    'total' => (float) $data->sum('total_amount'),
                    'distribution' => $data
                ]
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get payments distribution analitycs: " . $e->getMessage());

            return response()->json(["error" => 'Error to get payments distribution analitycs'], 500);
        }
    }

    
    /**
     * This PHP function retrieves attendance summary analytics data based on a specified period and
     * caches the result for future use.
     *
     * @param Request request The `attendancesSummary` function takes a `Request` object as a
     * parameter. This object is used to retrieve input data from the HTTP request made to the server.
     * The function then processes this input data to generate a summary of attendances.
     * 
     * @return JsonResponse The `attendancesSummary` function returns a JSON response. If the data
     * retrieved from the cache is empty (count is 0), it returns a JSON response with a message
     * "Resource not found" and status code 404. If an error occurs during the process, it logs the
     * error and returns a JSON response with an error message "Error to get attendances summary
     * analytics" and status code
     */
    public function attendancesSummary(Request $request): JsonResponse
    {
        try {

            [$from, $to, $cacheKeyPeriod] = $this->periodService->resolvePeriod($request);

            $cacheKey = "analytics:attendances:summary:{$cacheKeyPeriod}";

            $data = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($from, $to) {

                $query = UserAttendance::query();

                $pipes = [
                    new DateRange($from, $to, 'user_attendances.created_at'),
                    new AttendanceSummary()
                ];

                foreach ($pipes as $pipe) {
                    $query = $pipe->apply($query);
                }

                return $query->get();

            });

            if($data->isEmpty()) {
                return response()->json(['message' => 'Resource not found'], 404);
            }
            
            return response()->json([
                'data' => $data
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get attendances summary analitycs: " . $e->getMessage());

            return response()->json(["error" => 'Error to get attendances summary analitycs'], 500);
        }
    }
}
