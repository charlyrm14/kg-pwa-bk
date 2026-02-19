<?php

declare(strict_types=1);

namespace App\QueryFilter\Pipes;

use Carbon\Carbon;
use App\QueryFilter\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class DateRange implements QueryFilter
{
    public function __construct(
        private Carbon $from,
        private Carbon $to,
        private string $column = 'created_at'
    ) {}

    public function apply(Builder $query): Builder
    {
        return $query->whereBetween(
            $this->column, [
                $this->from->toDateTimeString(),
                $this->to->toDateTimeString()
            ]
        );
    }
}
