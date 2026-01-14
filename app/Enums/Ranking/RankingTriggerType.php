<?php

declare(strict_types=1);

namespace App\Enums\Ranking;

enum RankingTriggerType: string
{
    case ACHIEVEMENT = 'achievement';
    case PAYMENT = 'payment';
    case LEVELS = 'levels';
    case ATTENDANCES = 'attendances';

    public function id(): int
    {
        return match ($this) {
            self::ACHIEVEMENT => 1,
            self::PAYMENT     => 2,
            self::TOURNAMENT  => 3,
            self::LEVELS      => 4,
            self::ATTENDANCES => 5,
        };
    }

    public static function ids(): array
    {
        return array_map(fn(self $case) => $case->id(), self::cases());
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}