<?php

declare(strict_types=1);

namespace App\Services\Ranking\Period;

use App\Models\{
    RankingEvent,
    RankingPeriod
};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class RankingUserPoint
{
    /**
     * Retrieve the total accumulated points per user within a given ranking period.
     *
     * This method aggregates all ranking events that occurred between the
     * start and end dates of the provided ranking period, grouping the results
     * by user and calculating the total points earned by each one.
     *
     * The result is ordered by total points in descending order, making it
     * suitable for ranking calculations.
     *
     * @param  RankingPeriod  $period
     *         The ranking period used to define the date range for point aggregation.
     *
     * @return Collection
     *         A collection of records containing:
     *         - user_id (int)
     *         - total_points (int)
     */
    public function getPoints(RankingPeriod $period): Collection
    {
        return RankingEvent::query()
            ->select('user_id', DB::raw('SUM(points) as total_points'))
            ->whereBetween('event_date', [
                $period->start_date, 
                $period->end_date
            ])
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->get();
    }
}