<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{
    Payment,
    User,
    UserAttendance
};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\QueryFilter\Pipes\DateRange;
use Illuminate\Support\Facades\Cache;
use App\Domain\Analytics\Services\DatePeriodService;
use App\Domain\Analytics\Services\RevenueGrowthCalculator;
use App\QueryFilter\Analytics\Attendances\AttendanceSummary;
use App\QueryFilter\Analytics\Payments\PaymentDistribution;
use App\QueryFilter\Analytics\Payments\RevenueTimeline;
use App\QueryFilter\Analytics\Users\UserComposition;

class AnalyticController extends Controller
{
    private const CACHE_TIME = 5;

    public function __construct(
        private DatePeriodService $periodService,
        private RevenueGrowthCalculator $revenueCalculator
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

            $data = Cache::remember($cacheKey, now()->addMinutes(self::CACHE_TIME), function () use ($from, $to) {

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

    /**
     * This PHP function retrieves user composition analytics data and returns it as a JSON response,
     * handling errors and logging any exceptions.
     *
     * @param Request request The code snippet you provided is a Laravel controller method that fetches
     * user data with some composition applied. It seems like the `UserComposition` class is
     * responsible for applying some additional filters or modifications to the user query.
     *
     * @return JsonResponse The `usersComposition` function returns a JSON response. If the data
     * retrieved from the query is empty, it returns a 404 status code with a message "Resource not
     * found". If an error occurs during the process, it logs the error and returns a 500 status code
     * with an error message "Error to get users composition analytics". Otherwise, it returns a 200
     * status code with the retrieved data
     */
    public function usersComposition(): JsonResponse
    {
        try {

            $cacheKey = "analytics:users:composition";

            $data = Cache::remember($cacheKey, now()->addMinutes(self::CACHE_TIME), function () {
                $query = User::query();

                $pipe = new UserComposition();
                $pipe->apply($query);

                return $query->get();
            });

            if($data->isEmpty()) {
                return response()->json(['message' => 'Resource not found'], 404);
            }
            
            return response()->json([
                'data' => [
                    'total' => $data->sum('total_users'),
                    'detail' => $data
                ]
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get users compostion analitycs: " . $e->getMessage());

            return response()->json(["error" => 'Error to get users compostion analitycs'], 500);
        }
    }

    /**
     * The function `revenueTimeline` retrieves revenue data for a specific year, caching the results
     * for 5 minutes and handling any errors that may occur.
     *
     * @param Request request The `revenueTimeline` function is responsible for generating revenue
     * analytics data based on the provided request parameters. Let's break down the key components of
     * this function:
     *
     * @return JsonResponse The `revenueTimeline` function returns a JSON response containing the
     * revenue data for a specific year. The data includes the base month's revenue amount and the
     * growth percentages for each month of the year. If an error occurs during the process, a JSON
     * response with an error message is returned.
     */
    public function revenueTimeline(Request $request): JsonResponse
    {
        try {

            [$from, $to, $year] = $this->periodService->resolveAnnualPeriod($request);

            $cacheKey = "analytics:revenue:timeline:{$year}";

            $data = Cache::remember($cacheKey, now()->addMinutes(self::CACHE_TIME), function () use ($from, $to, $year) {

                $query = Payment::query();

                $pipes = [
                    new DateRange($from, $to, 'payments.payment_date'),
                    new RevenueTimeline()
                ];

                foreach ($pipes as $pipe) {
                    $query = $pipe->apply($query);
                }

                $payments = $query->get()->pluck('total', 'month');

                $months = $this->revenueCalculator->fillMonths($year, $payments);
                $baseAmount = $this->revenueCalculator->calculateBaseAmount($months);
                $growth = $this->revenueCalculator->calculatePercentages($months, $baseAmount, $year);

                return [
                    'meta' => [
                        'year' => $year
                    ],
                    'baseMonth' => [
                        'month' => 'Ene' . ' ' . $year,
                        'amount' => $baseAmount
                    ],
                    'growth' => $growth
                ];
            });

            return response()->json([
                'data' => $data
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get revenue timeline analitycs: " . $e->getMessage());

            return response()->json(["error" => 'Error to get revenue timeline analitycs'], 500);
        }
    }
}
