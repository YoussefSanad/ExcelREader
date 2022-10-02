<?php

use App\Grades\GradeFactory;
use App\Grades\Level;
use App\Grades\LevelType;
use App\Grades\Score;
use App\Grades\Undefined;
use PHPUnit\Framework\TestCase;

class GradeFactoryTest extends TestCase
{
    public function test_createGrade_returns_Level_when_a_valid_LevelType_value_is_passed()
    {
        $this->assertInstanceOf(Level::class, GradeFactory::createGrade(
            LevelType::A->value,
            'john',
            'drive'
        ));
    }

    public function test_createGrade_returns_Score_when_a_numeric_value_is_passed()
    {
        $this->assertInstanceOf(Score::class, GradeFactory::createGrade(
            '12',
            'john',
            'drive'
        ));
        $this->assertInstanceOf(Score::class, GradeFactory::createGrade(
            '12.5',
            'john',
            'drive'
        ));
    }

    public function test_createGrade_returns_Undefined_when_a_non_numeric_or_a_non_LevelType_grade_is_passed()
    {
        $this->assertInstanceOf(Undefined::class, GradeFactory::createGrade(
            null,
            'john',
            'drive'
        ));
        $this->assertInstanceOf(Undefined::class, GradeFactory::createGrade(
            '%$#$%@#$',
            'john',
            'drive'
        ));
        $this->assertInstanceOf(Undefined::class, GradeFactory::createGrade(
            '',
            'john',
            'drive'
        ));
    }
}