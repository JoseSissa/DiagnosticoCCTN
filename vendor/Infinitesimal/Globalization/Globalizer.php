<?php

namespace Infinitesimal\Globalization;

use Infinitesimal\Path;

class Globalizer implements GlobalizerInterface
{
    const NOT_FOUND_MODE_KEY = 0;
    const NOT_FOUND_MODE_ERROR = 1;

    private $data;
    private $defaultLanguage;
    private $notFoundMode;

    public function __construct(string $defaultLanguage = 'en', int $notFoundMode = 0, string $dataPath = '/Setup/Translation.json')
    {
        $this->$notFoundMode = $notFoundMode;
        $this->setupLanguage($defaultLanguage);
        $this->setupLocalizationData($dataPath);
    }

    public function setupLanguage(string $language)
    {
        $this->defaultLanguage = $language;
    }

    private function setupLocalizationData(string $dataPath)
    {
        $jsonString = file_get_contents(Path::path($dataPath));
        $this->data = json_decode($jsonString, true);
    }

    public function globalize(string $key): string
    {
        return $this->globalizeToLanguage($key, $this->defaultLanguage);
    }

    public function globalizeToLanguage(string $key, string $targetLanguage)
    {
        $translation = $this->data[$key][$targetLanguage] ?? null;

        if ($translation !== null) return $translation;
        if ($this->notFoundMode === self::NOT_FOUND_MODE_KEY) return $key;
        throw new GlobalizationException();
    }
}