<?php

use App\Calculators\Calculator;
use App\Calculators\LowestValueCalculator;
use App\Calculators\ParticipantGradeCalculator;
use App\Calculators\TypeValueCalculator;
use App\Grades\GradeFactory;
use PHPUnit\Framework\TestCase;

class TypeValueCalculatorTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new TypeValueCalculator();
    }

    public function test_calculate_returns_type_of_the_given_column_name()
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

        $expected = 'The type of Total is ‘score’';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_type_of_the_given_column_name_when_atleast_one_grade_has_a_type()
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
                GradeFactory::createGrade('3.2', 'Guus Geluk', 'Total')
            ]
        ];

        $expected = 'The type of Total is ‘score’';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_undefined_message_when_all_grades_are_undefined()
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

        $expected = 'The type of Total is ‘undefined’';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }

    public function test_calculate_returns_undefined_message_when_no_grades_present()
    {
        $columnName = 'Total';
        $mappedData = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
            ]
        ];

        $expected = 'The type of Total is ‘undefined’';

        $this->assertEquals($expected, $this->calculator->calculate($mappedData, $columnName));
    }
}