<?php

namespace App;

class FileReader
{
    private string $fileName;
    private array $fileData;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->fileData = [];
    }

    public function getRows(): array
    {
        $file = fopen($this->fileName, 'r');
        while (!feof($file)) {
            $this->fileData[] = fgets($file);
        }
        fclose($file);
        return $this->fileData;
    }

}