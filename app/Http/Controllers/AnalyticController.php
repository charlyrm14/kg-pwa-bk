<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\QueryFilter\Pipes\DateRange;
use Illuminate\Support\Facades\Cache;
use App\Domain\Analytics\Services\DatePeriodService;
use App\QueryFilter\Analytics\Payments\PaymentDistribution;



class AnalyticController extends Controller
{
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

            $data = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($from, $to) {

                $query = Payment::query();

                $pipes = [
                    new DateRange($from, $to, 'payment_date'),
                    new PaymentDistribution()
                ];

                foreach ($pipes as $pipe) {
                    $query = $pipe->apply($query);
                }

                $result = $query->get();
            
                return [
                    'total' => (float) $result->sum('total_amount'),
                    'distribution' => !$result->isEmpty() ? $result : null
                ];
            });

            return response()->json(['data' => $data], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get payments analitycs: " . $e->getMessage());

            return response()->json(["error" => 'Error to get payments analitycs'], 500);
        }
    }
}
