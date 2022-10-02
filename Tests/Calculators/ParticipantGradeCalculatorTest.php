<?php

use App\Calculators\Calculator;
use App\Calculators\LowestValueCalculator;
use App\Calculators\ParticipantGradeCalculator;
use App\Grades\GradeFactory;
use PHPUnit\Framework\TestCase;

class ParticipantGradeCalculatorTest extends TestCase
{
    private Calculator $calculator;

    public function test_calculate_returns_grade_of_the_given_participant()
    {
        $this->calculator = new ParticipantGradeCalculator(1);
        $columnName = 'Total';
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('3.4', 'Tante Test', 'Total'),
                GradeFactory::createGrade('3.2', 'Guus Geluk', 'Total')
            ]
        ];

        $expected = 'Tante Test scored 3.4 on Total';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_participant_doesnt_exist_when_an_invalid_number_is_passed()
    {
        $invalidIndex = 6;
        $this->calculator = new ParticipantGradeCalculator($invalidIndex);
        $columnName = 'Total';
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('3.4', 'Tante Test', 'Total'),
                GradeFactory::createGrade('3.2', 'Guus Geluk', 'Total')
            ]
        ];

        $expected = "Participant doesn't exist";

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

}