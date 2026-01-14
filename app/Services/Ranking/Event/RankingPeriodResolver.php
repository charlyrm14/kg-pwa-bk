<?php

declare(strict_types=1);

namespace App\Services\Ranking\Event;

use App\Models\RankingPeriod;

class RankingPeriodResolver
{
    /**
     * The function `resolve` retrieves a single `RankingPeriod` record based on specified conditions.
     * 
     * @param string eventDate It looks like the `resolve` function is trying to retrieve a
     * `RankingPeriod` based on certain conditions. However, the `where` method in the query builder is
     * not correctly structured.
     * 
     * @return ?RankingPeriod The `resolve` function is returning a single `RankingPeriod` object that
     * matches the specified conditions in the query. The query is looking for a `RankingPeriod` where
     * the `start_date`, `end_date`, and `status` are all matching specific values. The `first()`
     * method is used to retrieve the first result that matches the conditions.
     */
    public function resolve(string $eventDate): ?RankingPeriod
    {
        return RankingPeriod::query()
            ->whereDate('start_date', '<=', $eventDate)
            ->whereDate('end_date', '>=', $eventDate)
            ->where('status', '<>', 'locked')
            ->first();
    }
}