<?php

use PHPUnit\Framework\TestCase;

class TestCaseWithReflection extends TestCase
{
    protected static function makeMethodAccessible(string $class, string $method): ?ReflectionMethod
    {
        try {
            $class = new ReflectionClass($class);
            $method = $class->getMethod($method);
            $method->setAccessible(true);
            return $method;

        } catch (ReflectionException $e) {
            var_dump($e->getMessage());
        }
        return null;
    }
}