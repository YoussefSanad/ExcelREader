<?php

namespace App\Grades;

include_once 'GradeType.php';

class Score extends Grade
{
    public function __construct(?string $score, string $participant, string $competency)
    {
        $this->score = $score;
        $this->participant = $participant;
        $this->competency = $competency;
        $this->type = GradeType::SCORE;
    }

    public function getGradeValue(): float
    {
        return floatval($this->score);
    }

    public function getGradeMessage(): string
    {
        $scoreValue = $this->getGradeValue();
        return sprintf('%s scored %s on %s', $this->participant, $scoreValue, $this->competency);
    }
}