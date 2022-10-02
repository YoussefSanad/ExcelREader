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
        foreach ($mappedData[$columnName] as $gradeObject) {
            if ($gradeObject instanceof Grade) {
                if ($gradeObject->getType() !== GradeType::UNDEFINED) {
                    return $gradeObject->getTypeMessage();
                }
            }
        }
        $undefinedTypeMessage = sprintf("The type of %s is ‘%s’", $columnName, GradeType::UNDEFINED->value);
        return $undefinedTypeMessage;
    }
}