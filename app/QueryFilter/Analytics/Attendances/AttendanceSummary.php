<?php

declare(strict_types=1);

namespace App\QueryFilter\Analytics\Attendances;

use App\QueryFilter\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class AttendanceSummary implements QueryFilter
{

    public function apply(Builder $query): Builder
    {
        return $query
            ->selectRaw("
                attendance_statuses.id,
                attendance_statuses.name,
                COUNT(user_attendances.id) as total_students
            ")
            ->join('attendance_statuses', 'attendance_statuses.id', '=', 'user_attendances.attendance_status_id')
            ->groupBy('attendance_statuses.id', 'attendance_statuses.name')
            ->orderBy('total_students');
    }
}
