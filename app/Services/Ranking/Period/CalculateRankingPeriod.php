<?php

declare(strict_types=1);

namespace App\Services\Ranking\Period;

use DomainException;
use App\Models\{
    RankingPeriod,
    RankingPeriodUser
};
use App\Services\Ranking\Period\RankingUserPoint;
use Illuminate\Support\Facades\DB;

class CalculateRankingPeriod
{
    public function __construct(
        private RankingUserPoint $rankingUserPoints
    ){}

    /**
     * Calculate and persist the ranking results for a given ranking period.
     *
     * This method performs the full ranking calculation process:
     * - Validates that the period is not locked or already calculated.
     * - Aggregates user points within the period.
     * - Resets any previously calculated results (recalculation scenario).
     * - Assigns positions based on total points.
     * - Persists the calculated rankings.
     * - Updates the ranking period status and calculation timestamp.
     *
     * The entire process is executed within a database transaction to ensure
     * data consistency.
     *
     * @param  RankingPeriod  $period
     *         The ranking period to be calculated.
     *
     * @throws DomainException
     *         If the period is locked, already calculated, or if no user points
     *         can be retrieved for the given period.
     *
     * @return void
     */
    public function calculate(RankingPeriod $period): void
    {
        if ($period->status === 'locked') {
            throw new DomainException('This ranking period is locked.');
        }

        if ($period->status === 'calculated') {
            throw new DomainException('This ranking period was already calculated.');
        }

        $userPoints = $this->rankingUserPoints->getPoints($period);
        
        if($userPoints->isEmpty()) {
            throw new DomainException("This user's points could not be obtained");
        }

        DB::transaction(function () use ($userPoints, $period) {

            /* Elimina resultados previos (recalculo) */
            RankingPeriodUser::where('ranking_period_id', $period->id)->delete();

            $position = (int) 1;
            
            $rows = $userPoints->map(function($row) use($period, &$position) {
                return [
                    'ranking_period_id' => $period->id,
                    'user_id' => $row->user_id,
                    'total_points' => $row->total_points,
                    'position' => $position++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            RankingPeriodUser::insert($rows->toArray());

            $period->update([
                'status' => 'calculated',
                'calculated_at' => now()
            ]);

        });
    }
}