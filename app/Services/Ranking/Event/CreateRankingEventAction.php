<?php

declare(strict_types=1);

namespace App\Services\Ranking\Event;

use App\Models\RankingEvent;
use App\DTOs\Ranking\Events\StoreRankingEventDTO;
use App\Services\Ranking\Event\RankingEventService;

class CreateRankingEventAction
{
    public function __construct(
        private RankingEventService $service
    ){}

    /**
     * The function executes and returns a new RankingEvent based on the provided StoreRankingEventDTO.
     * 
     * @param StoreRankingEventDTO dto The `execute` function takes a parameter of type
     * `StoreRankingEventDTO` named ``. This parameter is used to create a `RankingEvent` by
     * calling the `createEvent` method on the `service` property. If you need further assistance or
     * have any specific questions about the
     * 
     * @return RankingEvent An instance of the `RankingEvent` class is being returned.
     */
    public function execute(StoreRankingEventDTO $dto): RankingEvent
    {
        return $this->service->create($dto);
    }
}