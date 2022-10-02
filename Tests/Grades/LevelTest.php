<?php

use App\Grades\Level;
use App\Grades\LevelType;
use PHPUnit\Framework\TestCase;


class LevelTest extends TestCase
{
    public function test___construct_inits_the_object_correctly_when_a_level_is_passed()
    {
        $score = LevelType::A->value;
        $participant = 'Test';
        $competency = 'Drive';
        $level = new Level($score, $participant, $competency);

        $expectedGradeMessage = sprintf('%s scored %d on %s', $participant, $score, $competency);

        $this->assertEquals($score, $level->getGrade());
        $this->assertEquals(LevelType::getLevelType($score)->getIntegerRepresentation(), $level->getGradeValue());
        $this->assertEquals($expectedGradeMessage, $level->getGradeMessage());
    }
}