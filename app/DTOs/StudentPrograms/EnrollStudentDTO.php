<?php

declare(strict_types=1);

namespace App\DTOs\StudentPrograms;

final class EnrollStudentDTO
{
    public function __construct(
        public readonly string $userUuid,
        public readonly int $swimProgramId,
        public readonly ?int $swimCategoryId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            userUuid: $data['user_uuid'],
            swimProgramId: $data['swim_program_id'],
            swimCategoryId: $data['swim_category_id'] ?? null,
        );
    }
}
