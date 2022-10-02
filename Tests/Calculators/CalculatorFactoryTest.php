<?php


use App\Calculators\AverageValueCalculator;
use App\Calculators\CalculationType;
use App\Calculators\CalculatorFactory;
use App\Calculators\HighestValueCalculator;
use App\Calculators\LowestValueCalculator;
use App\Calculators\ParticipantGradeCalculator;
use App\Calculators\TypeValueCalculator;
use PHPUnit\Framework\TestCase;

class CalculatorFactoryTest extends TestCase
{
    public function test_createCalculator_returns_AverageCalculator_when_average_is_given()
    {
        $calculator = CalculatorFactory::createCalculator(CalculationType::AVERAGE->value);
        $this->assertInstanceOf(AverageValueCalculator::class, $calculator);
    }

    public function test_createCalculator_returns_HighestValueCalculator_when_highest_is_given()
    {
        $calculator = CalculatorFactory::createCalculator(CalculationType::HIGHEST->value);
        $this->assertInstanceOf(HighestValueCalculator::class, $calculator);
    }

    public function test_createCalculator_returns_LowestValueCalculator_when_lowest_is_given()
    {
        $calculator = CalculatorFactory::createCalculator(CalculationType::LOWEST->value);
        $this->assertInstanceOf(LowestValueCalculator::class, $calculator);
    }

    public function test_createCalculator_returns_TypeValueCalculator_when_type_is_given()
    {
        $calculator = CalculatorFactory::createCalculator(CalculationType::TYPE->value);
        $this->assertInstanceOf(TypeValueCalculator::class, $calculator);
    }

    public function test_createCalculator_returns_ParticipantGradeCalculator_when_other_values_are_given()
    {
        $randomValue = 'random value';
        $calculator = CalculatorFactory::createCalculator($randomValue);
        $this->assertInstanceOf(ParticipantGradeCalculator::class, $calculator);
    }

}