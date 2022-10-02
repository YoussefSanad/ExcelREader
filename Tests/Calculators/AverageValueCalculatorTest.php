<?php

use App\Calculators\AverageValueCalculator;
use App\Calculators\Calculator;
use App\Grades\GradeFactory;
use PHPUnit\Framework\TestCase;

class AverageValueCalculatorTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new AverageValueCalculator();
    }

    public function test_calculate_returns_average_of_the_given_columnName_values()
    {
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

        $expectedMessage = "The average score for Total is 3.3";

        $this->assertEquals($expectedMessage, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_average_of_the_given_columnName_values_of_type_Level()
    {
        $columnName = 'Total';
        $aGrade = GradeFactory::createGrade('A', 'Tante Test', 'Total');
        $cGrade = GradeFactory::createGrade('C', 'Guus Geluk', 'Total');
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                $aGrade,
                $cGrade
            ]
        ];

        $expectedMessage = "The average score for Total is B";

        $this->assertEquals($expectedMessage, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_average_of_the_given_columnName_values_while_excluding_undefined_grades()
    {
        $columnName = 'Consciousness';
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

        $expectedMessage = "The average score for Consciousness is 1.2";

        $this->assertEquals($expectedMessage, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_average_of_type_Level_while_excluding_undefined()
    {
        $columnName = 'Total';
        $aGrade = GradeFactory::createGrade('A', 'Tante Test', 'Total');
        $cGrade = GradeFactory::createGrade('', 'Guus Geluk', 'Total');
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                $aGrade,
                $cGrade
            ]
        ];

        $expectedMessage = "The average score for Total is A";

        $this->assertEquals($expectedMessage, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_undefined_average_when_all_values_are_undefined()
    {
        $columnName = 'Consciousness';
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('3.4', 'Tante Test', 'Total'),
                GradeFactory::createGrade('3.2', 'Guus Geluk', 'Total')
            ]
        ];
        $expectedMessage = "The average score for Consciousness is undefined";

        $this->assertEquals($expectedMessage, $this->calculator->calculate($mappedData, $columnName));
    }
}