<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\QueryFilter\Ranking\PeriodFilter;
use App\Services\Ranking\Query\GetRankingService;
use App\Http\Resources\Ranking\IndexRankingCollection;

class RankingController extends Controller
{
    public function __construct(
        private GetRankingService $getRankingService
    ){}

    /**
     * Display a list of published rankings filtered by query parameters.
     *
     * Supported query parameters:
     * - period: diaria | semanal | mensual | trimestral | anual
     *
     * The controller delegates all business logic to the service layer and
     * returns a formatted JSON response.
     *
     * @param Request $request The incoming HTTP request.
     * @return JsonResponse The JSON response containing ranking data.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            
            $filters = [
                new PeriodFilter($request->query('period'))
            ];

            $rankings = $this->getRankingService->execute($filters);

            if($rankings->isEmpty()) {
                return response()->json(['message' => 'Not results found'], 404);
            }
        
            return response()->json([
                'data' => new IndexRankingCollection($rankings)
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get ranking data: " . $e->getMessage());

            return response()->json(["error" => 'Error to get ranking data'], 500);
        }
    }
}
