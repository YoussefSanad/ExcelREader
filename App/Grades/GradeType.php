<?php

namespace App\Grades;


enum GradeType: string
{
    case SCORE = "score";
    case LEVEL = "level";
    case UNDEFINED = "undefined";
}
