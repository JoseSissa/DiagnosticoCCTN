<?php

namespace Infinitesimal\Routing;

class RouteFinder
{
    private $registeredRoutes = [];

    public function add(array $methods, string $routeRegex, RoutingPath $routingPath): void
    {
        $this->registeredRoutes[] = [$methods, $routeRegex, $routingPath];
    }

    public function get(string $method, string $route): RoutingPath
    {
        foreach ($this->registeredRoutes as $registeredRoute)
        {
            if (in_array($method, $registeredRoute[0]) && preg_match("{^$registeredRoute[1]$}", $route) === 1)
                return $registeredRoute[2];
        }

        throw new RouteNotRegisteredException();
    }
}