<?php

namespace App\Grades;

include_once 'GradeType.php';

abstract class Grade
{
    protected GradeType $type;
    protected null|string $score;
    protected string $participant;
    protected string $competency;

    abstract public function __construct(?string $score, string $participant, string $competency);

    public function getGrade(): ?string
    {
        return $this->score ?? null;
    }

    public function getType(): GradeType
    {
        return $this->type;
    }

    public function getTypeMessage(): string
    {
        return sprintf("The type of %s is ‘%s’", $this->competency, $this->type->value);
    }

    abstract public function getGradeValue(): int|float|null;

    abstract public function getGradeMessage(): string;
}