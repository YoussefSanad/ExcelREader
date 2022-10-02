<?php

namespace App\Calculators;

include_once 'CalculationType.php';
include_once 'Calculator.php';
include_once 'HighestValueCalculator.php';
include_once 'LowestValueCalculator.php';
include_once 'AverageValueCalculator.php';
include_once 'TypeValueCalculator.php';
include_once 'ParticipantGradeCalculator.php';

class CalculatorFactory
{
    public static function createCalculator(string $calculation): Calculator
    {
        $calculationType = CalculationType::getCalculationType($calculation);
        return match ($calculationType) {
            CalculationType::HIGHEST => new HighestValueCalculator(),
            CalculationType::LOWEST => new LowestValueCalculator(),
            CalculationType::AVERAGE => new AverageValueCalculator(),
            CalculationType::TYPE => new TypeValueCalculator(),
            default => new ParticipantGradeCalculator($calculation)
        };
    }

}