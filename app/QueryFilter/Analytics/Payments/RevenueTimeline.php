<?php

declare(strict_types=1);

namespace App\QueryFilter\Analytics\Payments;

use App\QueryFilter\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class RevenueTimeline implements QueryFilter
{
    public function apply(Builder $query): Builder
    {
        return $query
            ->selectRaw("
                extract(month from payment_date) as month,
                SUM(amount) as total
            ")
            ->groupByRaw('month')
            ->orderByRaw('month');
    }
}
