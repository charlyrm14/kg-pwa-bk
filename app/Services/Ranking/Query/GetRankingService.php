<?php

declare(strict_types=1);

namespace App\Services\Ranking\Query;

use App\Models\RankingPeriod;
use Illuminate\Support\Collection;

class GetRankingService
{
    /**
     * Execute the ranking query using the provided filters.
     *
     * @param array<QueryFilter> $filters A list of query filters to apply.
     * @return Collection A collection of ranking periods with their ranked users.
     */
    public function execute(array $filters): Collection
    {
        $query = RankingPeriod::query()
            ->where('status', 'published')
            ->with([
                'users' => fn($q) => $q->orderBy('position'),
                'users.user',
            ]);

        foreach($filters as $filter) {
            $query = $filter->apply($query);
        }

        return $query->limit(10)->get();
    }
}