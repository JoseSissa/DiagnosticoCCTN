<?php

namespace Infinitesimal;

use Infinitesimal\Routing\Router;
use Psr\Container\ContainerInterface;

interface RouterSetupInterface
{
    public function setupRouter(Router $router, ContainerInterface $container);
}