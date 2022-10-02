<?php

use App\Grades\Level;
use App\Grades\LevelType;
use App\Grades\Score;
use PHPUnit\Framework\TestCase;


class ScoreTest extends TestCase
{
    public function test___construct_inits_the_object_correctly_when_a_score_is_passed()
    {
        $score = '5.5';
        $participant = 'Test';
        $competency = 'Drive';
        $scoreObject = new Score($score, $participant, $competency);

        $expectedGradeMessage = "Test scored 5.5 on Drive";

        $this->assertEquals($score, $scoreObject->getGrade());
        $this->assertSame(5.5, $scoreObject->getGradeValue());
        $this->assertEquals($expectedGradeMessage, $scoreObject->getGradeMessage());
    }

    public function test___construct_inits_the_object_correctly_when_a_score_is_passed_as_0()
    {
        $score = 0;
        $participant = 'Test';
        $competency = 'Drive';
        $scoreObject = new Score($score, $participant, $competency);

        $expectedGradeMessage = sprintf('%s scored %d on %s', $participant, $score, $competency);

        $this->assertEquals(0, $scoreObject->getGrade());
        $this->assertEquals(0, $scoreObject->getGradeValue());
        $this->assertEquals($expectedGradeMessage, $scoreObject->getGradeMessage());
    }
}