<?php

namespace App\Calculators;

use App\Grades\Grade;
use App\Grades\GradeType;
use App\Grades\LevelType;

include_once 'CalculationType.php';
include_once 'Calculator.php';
include_once 'App/Grades/Grade.php';

class AverageValueCalculator implements Calculator
{
    public function calculate(array $mappedData, string $columnName): string
    {
        [$sum, $gradeType, $numberOfGrades] = $this->getValuesSum($mappedData[$columnName]);
        $average = $this->getAverage($sum, $numberOfGrades, $gradeType);
        return $this->getAverageMessage($average, $columnName);
    }

    private function getValuesSum($mappedData): array
    {
        $sum = 0.0;
        $gradeType = GradeType::UNDEFINED;
        $numberOfGrades = count($mappedData);

        foreach ($mappedData as $gradeObject) {
            if ($gradeObject instanceof Grade) {
                if ($gradeObject->getType() === GradeType::UNDEFINED) {
                    $numberOfGrades--;
                } else {
                    $gradeType = $gradeObject->getType();
                    $sum += $gradeObject->getGradeValue();
                }
            }
        }
        return array($sum, $gradeType, $numberOfGrades);
    }

    private function getAverage(float $sum, int $numberOfGrades, GradeType $gradeType): string|null
    {
        if ($gradeType == GradeType::UNDEFINED) {
            return null;
        } else {
            $average = $sum / $numberOfGrades;

            return $gradeType == GradeType::LEVEL ?
                LevelType::getLevelTypeFromDecimalRepresentation((int)floor($average))->value :
                $average;
        }
    }

    private function getAverageMessage(?string $average, string $columnName): string
    {
        if (is_null($average)) {
            return sprintf("The average score for %s is undefined", $columnName);
        } elseif (is_numeric($average)) {
            return sprintf("The average score for %s is %s", $columnName, $average);
        } else {
            return sprintf("The average score for %s is %s", $columnName, $average);
        }
    }
}