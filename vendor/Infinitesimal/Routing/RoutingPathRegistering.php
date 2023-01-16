<?php

namespace Infinitesimal\Routing;

interface RoutingPathRegistering
{
    /** @param string|array $middlewares */
    public function middleware($middlewares);
}