<?php

namespace Infinitesimal;

use Psr\Container\ContainerInterface;

class Container
{
    /** @var ContainerInterface */
    private static $container;

    public static function registerContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }

    public static function get(string $id)
    {
        return self::$container->get($id);
    }

    public static function has(string $id)
    {
        return self::$container->has($id);
    }
}