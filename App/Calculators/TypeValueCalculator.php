<?php

namespace App\Calculators;

use App\Grades\Grade;
use App\Grades\GradeType;


include_once 'CalculationType.php';
include_once 'Calculator.php';
include_once 'App/Grades/Grade.php';
include_once 'App/Grades/GradeType.php';

class TypeValueCalculator implements Calculator
{
    public function calculate(array $mappedData, string $columnName): string
    {
        $undefinedTypeMessage = sprintf("The type of %s is ‘%s’", $columnName, GradeType::UNDEFINED->value);
        if (count($mappedData[$columnName]) === 0) return $undefinedTypeMessage;

        foreach ($mappedData[$columnName] as $gradeObject) {
            if ($gradeObject instanceof Grade) {
                if ($gradeObject->getType() !== GradeType::UNDEFINED) {
                    return $gradeObject->getTypeMessage();
                }
            }
        }
        return $undefinedTypeMessage;
    }
}