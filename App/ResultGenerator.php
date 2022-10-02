<?php

namespace App;


use App\Calculators\CalculatorFactory;

include_once 'InMemoryDataMapper.php';
include_once 'Calculators/CalculationType.php';
include_once 'Calculators/CalculatorFactory.php';

class ResultGenerator
{
    private InMemoryDataMapper $mapper;
    private string $columnName;
    private string $participantOrCalculation;

    public function __construct(string $columnName, string $participantOrCalculation)
    {
        $this->mapper = new InMemoryDataMapper();
        $this->mapper->buildMap();

        $this->columnName = $columnName;
        $this->participantOrCalculation = $participantOrCalculation;
    }

    public function generate(): void
    {

        $mappedData = $this->mapper->getMappedData();
        $this->checkColumnNameExists($mappedData, $this->columnName);
        $calculator = CalculatorFactory::createCalculator($this->participantOrCalculation);
        print $calculator->calculate($mappedData, $this->columnName);
    }

    private function checkColumnNameExists(array $mappedData, string $columnName):void
    {
        if (!array_key_exists($columnName, $mappedData)) {
            print "competency Not Found\n";
            die();
        }
    }

}