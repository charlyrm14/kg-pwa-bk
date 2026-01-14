<?php

declare(strict_types=1);

namespace App\Services\Ranking\Event;

use App\Models\RankingEvent;

class RankingEventWriter
{
    /**
     * The function creates a new RankingEvent object using the provided data.
     * 
     * @param array data The `create` function takes an array `` as a parameter. This array likely
     * contains the data needed to create a new `RankingEvent` object. The function then calls the
     * static `create` method of the `RankingEvent` class, passing the `` array as an
     * 
     * @return RankingEvent An instance of the `RankingEvent` class is being returned.
     */
    public function create(array $data): RankingEvent
    {
        return RankingEvent::create($data);
    }
}