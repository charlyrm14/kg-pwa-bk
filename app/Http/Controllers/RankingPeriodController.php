<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DomainException;
use App\Models\RankingPeriod;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\{
    Request,
    JsonResponse
};
use App\Services\Ranking\Period\CalculateRankingPeriod;

class RankingPeriodController extends Controller
{
    /**
     * Trigger the calculation of a ranking period.
     *
     * This endpoint delegates the ranking calculation process to the
     * corresponding domain action. The controller is responsible only for
     * request handling, delegation, and HTTP response formatting.
     *
     * @param  RankingPeriod           $period
     *         The ranking period to be calculated.
     * @param  CalculateRankingPeriod  $action
     *         The action responsible for executing the ranking calculation logic.
     *
     * @return JsonResponse
     *         A JSON response indicating the result of the operation.
     *
     * @throws DomainException
     *         When the ranking period cannot be calculated due to domain rules.
     */
    public function calculate(RankingPeriod $period, CalculateRankingPeriod $action): JsonResponse
    {
        try {

            $action->calculate($period);
            
            return response()->json(['message' => 'Ranking period calculated successfully'], 201);

        } catch (DomainException $e) {

            return response()->json(['message' => $e->getMessage()], 422);

        }  catch (\Throwable $e) {

            Log::error("Error to calculate period: " . $e->getMessage());

            return response()->json(["error" => 'Error to calculate period'], 500);
        }
    }
}
