<?php

namespace App\Calculators;

interface Calculator
{
    public function calculate(array $mappedData, string $columnName): string;
}