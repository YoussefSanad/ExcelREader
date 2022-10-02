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

class LowestValueCalculator implements Calculator
{
    public function calculate(array $mappedData, string $columnName): string
    {
        $lowest = null;
        $type = GradeType::UNDEFINED;
        foreach ($mappedData[$columnName] as $gradeObject) {
            if ($gradeObject instanceof Grade) {
                if ($gradeObject instanceof Undefined) continue;
                $type = $gradeObject->getType();
                $gradeValue = $gradeObject->getGradeValue();
                if (!$lowest) {
                    $lowest = $gradeValue;
                } else {
                    $lowest = min($lowest, $gradeValue);
                }
            }
        }
        return $this->getLowestValueMessage($type, $lowest, $columnName);
    }


    public function getLowestValueMessage(GradeType $type, mixed $lowest, string $columnName): string
    {
        if ($type === GradeType::UNDEFINED){
            return sprintf("The lowest score for %s is undefined", $columnName);
        } elseif ($type === GradeType::LEVEL){
            $level =  LevelType::getLevelTypeFromDecimalRepresentation($lowest);
            return sprintf("The lowest score for %s is %s", $columnName, $level->value);
        } else {
            return sprintf("The lowest score for %s is %s", $columnName, $lowest);
        }
    }
}