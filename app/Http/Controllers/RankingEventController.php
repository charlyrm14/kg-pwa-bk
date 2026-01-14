<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DomainException;
use App\Models\{
    RankingRule
};
use App\Http\Requests\Ranking\Events\{
    StoreEventRequest
};
use App\DTOs\Ranking\Events\{
    StoreRankingEventDTO
};
use Illuminate\Http\{
    Request,
    JsonResponse
};
use Illuminate\Support\Facades\Log;
use App\Services\Ranking\Event\{
    CreateRankingEventAction
};
use App\Http\Resources\Ranking\Event\StoreRankingEventResource;


class RankingEventController extends Controller
{
    public function __construct(
        private CreateRankingEventAction $createRankingEvent
    ){}

    /**
     * Store a new ranking event.
     *
     * This endpoint registers a ranking event for a user based on a trigger
     * (attendance, payment, achievement, etc.). The request is validated,
     * transformed into a DTO, and delegated to a use case that handles
     * business rules such as:
     * - rule resolution
     * - period resolution
     * - points limit validation
     * - event persistence
     *
     * The controller only orchestrates the request flow and returns
     * the appropriate HTTP response.
     *
     * @param  StoreEventRequest  $request
     *         Validated request containing the ranking event data.
     *
     * @return JsonResponse
     *         201: Ranking event successfully created.
     *         422: Business rule violation (e.g. points limit exceeded).
     *         500: Unexpected server error.
     *
     * @throws \DomainException
     *         When a domain rule is violated.
     *
     * @throws \Throwable
     *         When an unexpected error occurs.
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        try {
            
            $dto = StoreRankingEventDTO::fromArray($request->validated());

            $event = $this->createRankingEvent->execute($dto);
            $event->load('rule');

            return response()->json([
                'data' => new StoreRankingEventResource($event)
            ], 201);

        } catch (DomainException $e) {

            return response()->json(['message' => $e->getMessage()], 422);

        } catch (\Throwable $e) {

            Log::error("Error to register ranking event: " . $e->getMessage());

            return response()->json(["error" => 'Error to register ranking event'], 500);
        }
    }
}
