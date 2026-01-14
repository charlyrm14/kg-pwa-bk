<?php

declare(strict_types=1);

namespace App\Services\Ranking\Event;

use App\Models\{
    User,
    RankingEvent,
    RankingRule,
    RankingPeriod
};
use App\DTOs\Ranking\Events\StoreRankingEventDTO;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\Ranking\Event\{
    RankingRuleFinder,
    RankingPeriodResolver,
    RankingEventWriter
};
use DomainException;

class RankingEventService
{
    public function __construct(
        private RankingRuleFinder $ruleFinder,
        private RankingPeriodResolver $periodResolver,
        private RankingEventWriter $writer
    ){}

    /**
     * The function creates a ranking event based on the provided data transfer object, performing
     * validations and retrieving necessary information before storing the event in the database.
     * 
     * @param StoreRankingEventDTO dto The `create` function takes a `StoreRankingEventDTO` object as a
     * parameter. This object contains the following properties:
     * 
     * @return RankingEvent A `RankingEvent` object is being returned from the `create` function.
     */
    public function create(StoreRankingEventDTO $dto): RankingEvent
    {
        $rule = $this->ruleFinder->findActive($dto->triggerType, $dto->triggerId);
        
        if(!$rule) {
            throw new DomainException("Rule not found");
        }
        
        $period = $this->periodResolver->resolve($dto->eventDate);
        
        if(!$period) {
            throw new DomainException("Ranking period not found");
        }

        $user = User::whereUuid($dto->userUuid)->first();

        $this->validatePointsLimit($user->id, $rule, $period, $rule->points_awarded);

        return $this->writer->create([
            'user_id' => $user->id,
            'ranking_rule_id' => $rule->id,
            'points' => $rule->points_awarded,
            'event_date' => $dto->eventDate,
            'metadata' => $dto->metadata
        ]);
    }

    /**
     * This PHP function validates if adding points to a user's ranking event exceeds the maximum
     * points limit set by a ranking rule for a specific period.
     * 
     * @param int userId The `userId` parameter is the ID of the user for whom we are validating the
     * points limit.
     * @param RankingRule rule The `validatePointsLimit` function you provided is used to check if
     * adding a certain number of points to a user's ranking will exceed the maximum points allowed per
     * period based on a specific ranking rule.
     * @param period The `validatePointsLimit` function you provided is used to check if adding a
     * certain number of points to a user's ranking in a specific period would exceed the maximum
     * points allowed by a ranking rule.
     * @param int pointsToAdd The `pointsToAdd` parameter in the `validatePointsLimit` function
     * represents the number of points that are being added to a user's ranking points. This function
     * is used to check if adding these points will exceed the maximum points allowed per period based
     * on a specific ranking rule.
     * 
     * @return If the condition `->max_points_per_period` is false (evaluates to falsey), then the
     * function will return early without performing any further operations.
     */
    public function validatePointsLimit(
        int $userId, 
        RankingRule $rule, 
        ?RankingPeriod $period,
        int $pointsToAdd
    )
    {
        if(!$rule->max_points_per_period) return
        
        $currentPoints = RankingEvent::query()
            ->where([
                ['user_id', $userId],
                ['ranking_rule_id', $rule->id]
            ])
            ->whereBetween('event_date', [
                $period->start_date,
                $period->end_date,
            ])
            ->sum('points');
            
        $totalAfter = $currentPoints + $pointsToAdd;

        if ($totalAfter > $rule->max_points_per_period) {
            throw new DomainException(
                "Points limit exceeded for rule '{$rule->name}' in this period"
            );
        }
    }
}