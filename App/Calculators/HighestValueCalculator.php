<?php

namespace App\Calculators;

use App\Grades\Grade;
use App\Grades\GradeType;
use App\Grades\LevelType;
use App\Grades\Undefined;

include_once 'CalculationType.php';
include_once 'Calculator.php';
include_once 'App/Grades/Grade.php';
include_once 'App/Grades/GradeType.php';
include_once 'App/Grades/Undefined.php';
include_once 'App/Grades/LevelType.php';

class HighestValueCalculator implements Calculator
{
    public function calculate(array $mappedData, string $columnName): string
    {
        $highest = null;
        $type = GradeType::UNDEFINED;
        foreach ($mappedData[$columnName] as $gradeObject) {
            if ($gradeObject instanceof Grade) {
                if ($gradeObject instanceof Undefined) continue;
                $type = $gradeObject->getType();
                $gradeValue = $gradeObject->getGradeValue();
                if (!$highest) {
                    $highest = $gradeValue;
                } else {
                    $highest = max($highest, $gradeValue);
                }
            }
        }
        return $this->getHighestValueMessage($type, $highest, $columnName);
    }


    public function getHighestValueMessage(GradeType $type, mixed $highest, string $columnName): string
    {
        if ($type === GradeType::UNDEFINED){
            return sprintf("The highest score for %s is undefined", $columnName);
        } elseif ($type === GradeType::LEVEL){
            $level =  LevelType::getLevelTypeFromDecimalRepresentation($highest);
            return sprintf("The highest score for %s is %s", $columnName, $level->value);
        } else {
            return sprintf("The highest score for %s is %s", $columnName, $highest);
        }
    }

}