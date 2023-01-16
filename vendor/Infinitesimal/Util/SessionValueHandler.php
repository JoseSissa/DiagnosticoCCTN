<?php

namespace Infinitesimal\Util;

abstract class SessionValueHandler
{
    private $sessionKey;
    private $defaultValue;

    public function __construct(string $sessionKey, $default = null)
    {
        $this->sessionKey = $sessionKey;
        $this->defaultValue = $default;
    }

    public function get()
    {
        return $_SESSION[$this->sessionKey] ?? $this->defaultValue;
    }

    public function set(string $value)
    {
        $_SESSION[$this->sessionKey] = $value;
    }
}