<?php

namespace App\Calculators;


use Exception;

include_once 'CalculationType.php';
include_once 'Calculator.php';
include_once 'App/Grades/Grade.php';

class ParticipantGradeCalculator implements Calculator
{
    private int $participantIndex;

    public function __construct(string|int $participantNumber)
    {
        if (is_string($participantNumber))
        {
            $participantNumber = intval($participantNumber);
        }
        $this->participantIndex = $participantNumber - 1;
    }

    public function calculate(array $mappedData, string $columnName): string
    {
        if (!array_key_exists($this->participantIndex, $mappedData[$columnName])) {
            return "Participant doesn't exist";
        }
        $gradeObject = $mappedData[$columnName][$this->participantIndex];
        return $gradeObject->getGradeMessage();
    }
}