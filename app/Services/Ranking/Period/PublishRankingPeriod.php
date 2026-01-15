<?php

declare(strict_types=1);

namespace App\Services\Ranking\Period;

use DomainException;
use App\Models\RankingPeriod;

class PublishRankingPeriod
{
    /**
     * Publishes a ranking period by changing its status to "published".
     *
     * This action represents a domain use case and enforces the business rules
     * required to make a ranking period publicly visible.
     *
     * A ranking period can only be published if:
     * - It is not locked.
     * - It has already been calculated.
     *
     * @param RankingPeriod $period
     *     The ranking period entity to be published.
     *
     * @throws DomainException
     *     If the ranking period is locked or has not been calculated yet.
     *
     * @return void
     */
    public function execute(RankingPeriod $period): void
    {
        if($period->status === 'locked') {
            throw new DomainException('Currently locked status.');
        }

        if($period->status !== 'calculated') {
            throw new DomainException('This period must be calculated');
        }

        $period->update(['status' => 'published']);
    }
}