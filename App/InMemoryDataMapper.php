<?php

namespace App;

use App\Grades\GradeFactory;

include_once 'FileReader.php';
include_once 'Grades/GradeFactory.php';


class InMemoryDataMapper
{
    const FILE_NAME = 'file.txt';
    const VALUES_SEPARATOR = ';';
    const PARTICIPANT_NAME_HEADER_INDEX = 0;

    private FileReader $fileReader;
    private array $mappedData;
    private array $headers;

    public function __construct(string $filePath = self::FILE_NAME)
    {
        $this->fileReader = new FileReader($filePath);
        $this->mappedData = [];
        $this->headers = [];
    }

    public function buildMap(): void
    {
        $fileData = $this->fileReader->getRows();
        $headersText = array_shift($fileData);
        $this->initHeadersAndMapWithHeaders($headersText);
        $this->mapValuesToHeaders($fileData);
    }


    private function initHeadersAndMapWithHeaders(string $headersText): void
    {
        $rawHeaders = $this->getValuesFromTextInArray($headersText);
        foreach ($rawHeaders as $header) {
            $header = $this->removeNonAlphanumericCharsFrom($header);
            $this->mappedData[$header] = [];
            $this->headers[] = $header;
        }
    }

    private function mapValuesToHeaders(array $fileDataWithoutHeaders): void
    {
        foreach ($fileDataWithoutHeaders as $rowIndex => $valuesText) {
            foreach ($this->getValuesFromTextInArray($valuesText) as $index => $value) {
                $this->addValueToMap($index, $rowIndex, $value);
            }
        }
    }

    private function addValueToMap(int $headerIndex, int $rowIndex, string $value): void
    {
        $currentHeader = $this->headers[$headerIndex];
        $value = $this->removeNonAlphanumericCharsFrom($value);
        if ($headerIndex == self::PARTICIPANT_NAME_HEADER_INDEX) {
            $this->mappedData[$currentHeader][] = $this->removeNonAlphanumericCharsFrom($value);
        } else {
            $participantHeader = $this->headers[self::PARTICIPANT_NAME_HEADER_INDEX];
            $participant = $this->mappedData[$participantHeader][$rowIndex];
            $this->mappedData[$currentHeader][] = GradeFactory::createGrade(
                $value ?? '',
                $participant,
                $currentHeader
            );
        }
    }

    private function getValuesFromTextInArray(string $valuesText): array
    {
        return explode(self::VALUES_SEPARATOR, $valuesText);

    }

    private function removeNonAlphanumericCharsFrom(string $text): string
    {
        return preg_replace('/[^\da-z .]/i', '', $text);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getMappedData(): array
    {
        return $this->mappedData;
    }
}
