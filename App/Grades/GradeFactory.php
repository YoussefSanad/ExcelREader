<?php

namespace App\Grades;

include_once 'Grade.php';
include_once 'LevelType.php';
include_once 'Score.php';
include_once 'Level.php';
include_once 'Undefined.php';

class GradeFactory
{
    public static function createGrade(?string $grade, string $participant, string $competency): Grade
    {
        if (LevelType::isLevel($grade)) {
            return new Level($grade, $participant, $competency);
        } elseif (is_numeric($grade)) {
            return new Score($grade, $participant, $competency);
        } else {
            return new Undefined($grade, $participant, $competency);
        }
    }
}