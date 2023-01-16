<?php

namespace Infinitesimal\Globalization\Persistence;

use Infinitesimal\Util\SessionValueHandler;

class GlobalizationSessionValue extends SessionValueHandler
{
    public function __construct(string $sessionKey = 'currentLocale')
    {
        parent::__construct($sessionKey);
    }
}