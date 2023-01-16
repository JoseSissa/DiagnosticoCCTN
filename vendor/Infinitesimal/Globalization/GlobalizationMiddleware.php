<?php

namespace Infinitesimal\Globalization;

use Infinitesimal\Globalization\Persistence\GlobalizationSessionValue;
use Infinitesimal\Middleware\Middleware;

class GlobalizationMiddleware implements Middleware
{
    private $globalizer;
    private $sessionValue;

    public function __construct(Globalizer $globalizer, GlobalizationSessionValue $sessionValue)
    {
        $this->globalizer = $globalizer;
        $this->sessionValue = $sessionValue;
    }

    public function run(): bool
    {
        $language = $this->sessionValue->get();
        if ($language !== null) $this->globalizer->setupLanguage($language);
        return true;
    }
}