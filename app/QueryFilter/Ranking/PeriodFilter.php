<?php

declare(strict_types=1);

namespace App\QueryFilter\Ranking;

use App\QueryFilter\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class PeriodFilter implements QueryFilter
{
    public function __construct(
        private readonly ?string $period
    ){}

    /**
     * Apply the period filter to the given query.
     *
     * @param Builder $query The base Eloquent query.
     * @return Builder The modified query with period constraints applied.
     */
    public function apply(Builder $query): Builder
    {
        if(!$this->period) {
            return $query;
        }
        
        return  match($this->period) {
            'diaria' => $query->whereHas('periodType', fn ($q) =>
                $q->where('slug', 'diaria')
            ),
            'semanal' => $query->whereHas('periodType', fn ($q) =>
                $q->where('slug', 'semanal')
            ),
            'mensual' => $query->whereHas('periodType', fn ($q) =>
                $q->where('slug', 'mensual')
            ),
            'trimestral' => $query->whereHas('periodType', fn ($q) =>
                $q->where('slug', 'trimestral')
            ),
            'anual' => $query->whereHas('periodType', fn ($q) =>
                $q->where('slug', 'anual')
            ),
            default => $query
        };
    }
}