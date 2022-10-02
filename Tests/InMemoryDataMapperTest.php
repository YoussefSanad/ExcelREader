<?php

use App\Grades\GradeFactory;
use App\InMemoryDataMapper;

include_once 'TestCaseWithReflection.php';


class InMemoryDataMapperTest extends TestCaseWithReflection
{
    private InMemoryDataMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new InMemoryDataMapper();
    }

    public function test_buildMap_populates_the_mappedData_variable_from_the_given_file()
    {
        $mapper = new InMemoryDataMapper('Tests/testfile.txt');
        $expectedMap = [
            'Participant' => ['Tante Test', 'Guus Geluk', 'Test Guy'],
            'Consciousness' => [
                GradeFactory::createGrade('A', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('B', 'Guus Geluk', 'Consciousness'),
                GradeFactory::createGrade('', 'Test Guy', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('2.2', 'Tante Test', 'Total'),
                GradeFactory::createGrade('55', 'Guus Geluk', 'Total'),
                GradeFactory::createGrade('', 'Test Guy', 'Total')
            ]
        ];

        $mapper->buildMap();
        $this->assertEquals($expectedMap, $mapper->getMappedData());
    }

    public function test_mapValuesToHeaders_builds_the_map_in_a_way_matching_the_table_with_grade_objects_as_scores()
    {
        $testHeadersText = "Participant;Consciousness;Total\n";
        $testValues = ["“Tante Test”;1.2;3.4", "“Guus Geluk”:;;3.2"];
        $expectedMap = [
            'Participant' => ['Tante Test', 'Guus Geluk'],
            'Consciousness' => [
                GradeFactory::createGrade('1.2', 'Tante Test', 'Consciousness'),
                GradeFactory::createGrade('', 'Guus Geluk', 'Consciousness')
            ],
            'Total' => [
                GradeFactory::createGrade('3.4', 'Tante Test', 'Total'),
                GradeFactory::createGrade('3.2', 'Guus Geluk', 'Total')
            ]
        ];

        $method = $this->makeMethodAccessible(InMemoryDataMapper::class, 'initHeadersAndMapWithHeaders');
        $method->invokeArgs($this->mapper, [$testHeadersText]);
        $method = $this->makeMethodAccessible(InMemoryDataMapper::class, 'mapValuesToHeaders');
        $method->invokeArgs($this->mapper, [$testValues]);

        $this->assertEquals($expectedMap, $this->mapper->getMappedData());
    }

    public function test_initHeadersAndMapWithHeaders_builds_the_headers_array_and_sets_up_the_map_keys()
    {
        $testHeadersText = "Participant;Consciousness;Drive;Total\n";
        $expectedHeadersArray = ['Participant', 'Consciousness', 'Drive', 'Total'];
        $expectedMap = ['Participant' => [], 'Consciousness' => [], 'Drive' => [], 'Total' => []];

        $method = $this->makeMethodAccessible(InMemoryDataMapper::class, 'initHeadersAndMapWithHeaders');
        $method->invokeArgs($this->mapper, [$testHeadersText]);

        $this->assertSame($expectedHeadersArray, $this->mapper->getHeaders());
        $this->assertSame($expectedMap, $this->mapper->getMappedData());
    }

    public function test_removeNonAlphanumericCharsFrom_returns_string_with_only_alphanumeric_chars()
    {
        $testString = '!@#$""\'\'some*%$^ tes#$^%@%#$t st@$#%ring@@';
        $expected = 'some test string';

        $method = $this->makeMethodAccessible(InMemoryDataMapper::class, 'removeNonAlphanumericCharsFrom');
        $actual = $method->invokeArgs($this->mapper, [$testString]);

        $this->assertEquals($expected, $actual);
    }
}