<?php

use App\Grades\LevelType;
use PHPUnit\Framework\TestCase;


class LevelTypeTest extends TestCase
{
    public function test_getLevelType_returns_LevelType_matching_the_given_string()
    {
        $this->assertSame(LevelType::A, LevelType::getLevelType('A'));
        $this->assertSame(LevelType::B, LevelType::getLevelType('B'));
        $this->assertSame(LevelType::C, LevelType::getLevelType('C'));
        $this->assertSame(LevelType::D, LevelType::getLevelType('D'));
    }

    public function test_getLevelType_returns_null_when_given_a_non_valid_grade()
    {
        $noLevel = LevelType::getLevelType('f');
        $this->assertEquals(null, $noLevel);

    }

    public function test_isLevel_returns_true_when_A_B_C_or_D_is_passed()
    {
        $this->assertTrue(LevelType::isLevel('A'));
        $this->assertTrue(LevelType::isLevel('B'));
        $this->assertTrue(LevelType::isLevel('C'));
        $this->assertTrue(LevelType::isLevel('D'));
        $this->assertTrue(LevelType::isLevel('a'));
        $this->assertTrue(LevelType::isLevel('b'));
        $this->assertTrue(LevelType::isLevel('c'));
        $this->assertTrue(LevelType::isLevel('d'));
    }

    public function test_isLevel_returns_false_when_string_other_than_A_B_C_or_D_is_passed()
    {
        $this->assertFalse(LevelType::isLevel('z'));
        $this->assertFalse(LevelType::isLevel('F'));
    }
}