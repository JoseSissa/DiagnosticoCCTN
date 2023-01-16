<?php

namespace Infinitesimal;

class Path
{
    private static $rootDir;

    public static function init($rootDir)
    {
        self::$rootDir = $rootDir;
    }

    public static function rootDir()
    {
        return self::$rootDir;
    }

    public static function path($file)
    {
        return self::$rootDir . $file;
    }

    public static function view($path)
    {
        return self::path("/Views/$path");
    }
}