<?php

declare(strict_types=1);

namespace App\QueryFilter\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface QueryFilter
{
    public function apply(Builder $query): Builder;
}