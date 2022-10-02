<?php

namespace App\Grades;

include_once 'LevelType.php';
include_once 'GradeType.php';

class Level extends Grade
{
    private LevelType $gradeType;

    public function __construct(?string $score, string $participant, string $competency)
    {
        $this->score = $score;
        $this->participant = $participant;
        $this->competency = $competency;
        $this->type = GradeType::LEVEL;
        $this->gradeType = LevelType::getLevelType($this->score);
    }

    public function getGradeValue(): int|float
    {
        return $this->gradeType->getIntegerRepresentation();
    }

    public function getGradeMessage(): string
    {
        return sprintf('%s scored %d on %s', $this->participant, $this->gradeType->value, $this->competency);
    }
}