<?php

declare(strict_types=1);

namespace App\QueryFilter\Analytics\Users;

use App\QueryFilter\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class UserComposition implements QueryFilter
{
    public function apply(Builder $query): Builder
    {
        return $query
            ->selectRaw("
                roles.id,
                roles.name,
                roles.slug,
                count(users.role_id) as total_users,
                ROUND(COUNT(users.id) * 100.0 / SUM(COUNT(users.id)) OVER(), 2) AS percentage
            ")
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->groupBy('roles.id', 'roles.name', 'roles.slug')
            ->orderBy('roles.id');
    }
}
