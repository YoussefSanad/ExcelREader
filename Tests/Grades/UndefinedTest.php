<?php

use App\Grades\Score;
use App\Grades\Undefined;
use PHPUnit\Framework\TestCase;


class UndefinedTest extends TestCase
{
    public function test___construct_inits_the_object_correctly_when_a_score_is_passed()
    {
        $score = '';
        $participant = 'Test';
        $competency = 'Drive';
        $scoreObject = new Undefined($score, $participant, $competency);

        $expectedGradeMessage = sprintf('%s has no score for %s', $participant, $competency);

        $this->assertEquals(null, $scoreObject->getGrade());
        $this->assertEquals(null, $scoreObject->getGradeValue());
        $this->assertEquals($expectedGradeMessage, $scoreObject->getGradeMessage());
    }
}