<?php

namespace Setup;

use Infinitesimal\Auth\AuthMiddleware;
use Infinitesimal\Auth\Authentication;
use Infinitesimal\Auth\AuthenticationException;
use Infinitesimal\Url;
use Infinitesimal\SetupInterface;

class InfinitesimalSetup implements SetupInterface
{
    public function setupOnAwake()
    {
        date_default_timezone_set('America/Bogota');
    }

    function setupContainer(\DI\Container $container)
    {
        //$container->set(\Infinitesimal\Database\SqliteDatabase::class, new \Infinitesimal\Database\SqliteDatabase('db.db'));
		//$container->set(AuthMiddleware::class, new AuthMiddleware($container->get(Authentication::class), Url::get('/login')));
        \Infinitesimal\Globalization\Globalization::registerGlobalizer($container->get(\Infinitesimal\Globalization\Globalizer::class));
    }
}