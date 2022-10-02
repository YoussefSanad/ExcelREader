<?php

namespace App\Grades;

enum LevelType: string
{
    case A = "A";
    case B = "B";
    case C = "C";
    case D = "D";

    public function getIntegerRepresentation(): int
    {
        return match ($this) {
            LevelType::A => 4,
            LevelType::B => 3,
            LevelType::C => 2,
            LevelType::D => 1,
        };
    }

    public static function getLevelTypeFromDecimalRepresentation(int $value): LevelType
    {
        return match ($value) {
            4 => LevelType::A,
            3 => LevelType::B,
            2 => LevelType::C,
            1 => LevelType::D,
        };
    }

    public static function getLevelType(?string $grade): ?LevelType
    {
        return match ($grade) {
            LevelType::A->value => LevelType::A,
            LevelType::B->value => LevelType::B,
            LevelType::C->value => LevelType::C,
            LevelType::D->value => LevelType::D,
            default => null
        };
    }

    public static function isLevel(?string $grade): bool
    {
        if (is_null($grade)) return false;
        $grade = strtoupper($grade);
        foreach (self::cases() as $case) {
            if ($grade === $case->value) return true;
        }
        return false;
    }
}
