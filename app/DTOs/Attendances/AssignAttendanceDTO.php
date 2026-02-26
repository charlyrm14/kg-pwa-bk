<?php

declare(strict_types=1);

namespace App\DTOs\Attendances;

final class AssignAttendanceDTO
{
    public function __construct(
        public readonly int $attendanceStatusId,
        public readonly ?string $attendanceDate
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            attendanceStatusId: $data['attendance_status_id'],
            attendanceDate: $data['attendance_date'] ?? null
        );
    }
}
