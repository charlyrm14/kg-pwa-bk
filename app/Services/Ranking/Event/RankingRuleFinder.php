<?php

declare(strict_types=1);

namespace App\Services\Ranking\Event;

use App\Models\RankingRule;

class RankingRuleFinder
{
    /**
     * This PHP function finds and returns an active ranking rule based on the trigger type and trigger
     * ID.
     * 
     * @param string triggerType The `triggerType` parameter is a string that specifies the type of
     * trigger for which we want to find an active `RankingRule`.
     * @param triggerId The `triggerId` parameter is a string that represents the ID of the trigger. It
     * is used in the `findActive` function to filter the ranking rules based on the provided
     * `triggerType` and `triggerId`. The function retrieves the first active `RankingRule` that
     * matches the specified
     * 
     * @return RankingRule The `findActive` function returns a single `RankingRule` object that meets
     * the specified conditions. The function queries the `RankingRule` model to find a rule where the
     * `trigger_type` matches the provided `` and the `is_active` field is set to `true`.
     * Additionally, it filters the results based on the `trigger_id` field matching the provided
     * `
     */
    public function findActive(string $triggerType, ?string $triggerId): ?RankingRule
    {
        return RankingRule::query()
            ->where([
                ['trigger_type', $triggerType],
                ['is_active', true]
            ])
            ->where(function ($query) use ($triggerId) {
                $query->where('trigger_id', $triggerId)
                    ->orWhereNull('trigger_id');
            })
            ->first();
    }
}