<?php

namespace App\Calculators;



enum CalculationType: string
{
    case LOWEST = "lowest";
    case HIGHEST = "highest";
    case AVERAGE = "average";
    case TYPE = "type";


    public static function getCalculationType(string $calculation): ?CalculationType
    {
        return match ($calculation) {
            CalculationType::LOWEST->value => CalculationType::LOWEST,
            CalculationType::HIGHEST->value => CalculationType::HIGHEST,
            CalculationType::AVERAGE->value => CalculationType::AVERAGE,
            CalculationType::TYPE->value => CalculationType::TYPE,
            default => null
        };
    }

    public static function isCalculationType(string $calculation): bool
    {
        foreach (self::cases() as $case) {
            if ($calculation === $case->value) return true;
        }
        return false;
    }
}
