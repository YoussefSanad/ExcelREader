<?php

use App\Calculators\Calculator;
use App\Calculators\LowestValueCalculator;
use App\Grades\GradeFactory;
use PHPUnit\Framework\TestCase;

class LowestValueCalculatorTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new LowestValueCalculator();
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

        $expected = 'The lowest score for Total is 3.2';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_average_of_the_given_columnName_values_when_grade_type_is_level()
    {
        $columnName = 'Total';
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('C', 'Tante Test', 'Total'),
                GradeFactory::createGrade('D', 'Guus Geluk', 'Total')
            ]
        ];

        $expected = 'The lowest score for Total is D';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_average_when_grade_type_is_level_excluding_undefined_values()
    {
        $columnName = 'Total';
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('', 'Tante Test', 'Total'),
                GradeFactory::createGrade('D', 'Guus Geluk', 'Total')
            ]
        ];

        $expected = 'The lowest score for Total is D';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_average_of_the_given_columnName_values_while_excluding_undefined_values()
    {
        $columnName = 'Total';
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('', 'Tante Test', 'Total'),
                GradeFactory::createGrade('0', 'Guus Geluk', 'Total')
            ]
        ];

        $expected = 'The lowest score for Total is 0';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_undefined_average_when_all_values_are_undefined()
    {
        $columnName = 'Total';
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('', 'Tante Test', 'Total'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Total')
            ]
        ];

        $expected = 'The lowest score for Total is undefined';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }


}