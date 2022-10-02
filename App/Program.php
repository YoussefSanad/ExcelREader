<?php

namespace App;

use App\ResultGenerator;

include_once 'InMemoryDataMapper.php';
include_once 'ResultGenerator.php';

class Program
{


    public function run(): void
    {
        $columnName = readline("Which column are you targeting? \n");
        $participantOrOperation = readline("For which participant or which function you want to run on that column? \n");
//        $columnName = 'fasdf';
//        $participantOrOperation = 3;
        $columnName = strip_tags($columnName);
        $participantOrOperation = strip_tags($participantOrOperation);
        $generator = new ResultGenerator($columnName, $participantOrOperation);
        $generator->generate();
    }
}

$main = new Program();
$main->run();
