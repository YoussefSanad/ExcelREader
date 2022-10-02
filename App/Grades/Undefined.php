<?php

namespace App\Grades;

include_once 'LevelType.php';
include_once 'GradeType.php';

class Undefined extends Grade
{
    public function __construct(?string $score, string $participant, string $competency)
    {
        $this->score = null;
        $this->participant = $participant;
        $this->competency = $competency;
        $this->type = GradeType::UNDEFINED;
    }

    public function getGradeValue(): int|float|null
    {
        return null;
    }

    public function getGradeMessage(): string
    {
        return sprintf('%s has no score for %s', $this->participant, $this->competency);
    }
}