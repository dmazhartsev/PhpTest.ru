<?php

namespace App\Services;

use Symfony\Component\Yaml\Yaml;

class ConfigReader
{
    private Yaml $yamlParser;
    private string $filePath;

    public function __construct()
    {
        $this->yamlParser = new Yaml();
        $this->filePath = __DIR__ . '/../../config/config.yml';
    }

    public function read(): array
    {
        return $this->yamlParser->parseFile($this->filePath);
    }

}