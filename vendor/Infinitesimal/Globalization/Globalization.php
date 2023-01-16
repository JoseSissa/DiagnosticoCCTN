<?php

namespace Infinitesimal\Globalization;

class Globalization
{
    /** @var GlobalizerInterface */
    private static $globalizer;

    public static function registerGlobalizer(GlobalizerInterface $globalizer)
    {
        self::$globalizer = $globalizer;
    }

    public static function globalize(string $key)
    {
        return self::$globalizer->globalize($key);
    }
}