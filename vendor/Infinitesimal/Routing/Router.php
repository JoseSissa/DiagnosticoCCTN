<?php

namespace Infinitesimal\Routing;

class Router
{
    /** @var RouteFinder */
    private $routeFinder;
    private $default;
    private $autoMiddlewares = [];

    public function __construct()
    {
        $this->routeFinder = new RouteFinder();
    }

    public function all(string $path): RoutingPathConfig
    {
        return $this->on(['GET', 'POST'], $path);
    }

    public function get(string $path): RoutingPathConfig
    {
        return $this->on(['GET'], $path);
    }

    public function post(string $path): RoutingPathConfig
    {
        return $this->on(['POST'], $path);
    }

    public function on(array $methods, string $path): RoutingPathConfig
    {
        $routingPath = new RoutingPath();
        $this->setupAutoMiddlewares($routingPath);
        $this->routeFinder->add($methods, $path, $routingPath);
        return $routingPath;
    }

    public function on404(): RoutingPathConfig
    {
        $this->default = new RoutingPath404();
        return $this->default;
    }

    public function getExecutableForRoute(string $method, string $route): ExecutableRoutingPath
    {
        try
        {
            $route = $this->getCleanRoute($route);
            return $this->routeFinder->get($method, $route);
        }
        catch (RouteNotRegisteredException $ex)
        {
            return $this->default;
        }
    }

    private function getCleanRoute(string $route): string
    {
        $arr = explode('?', $route, 2);
        return rtrim($arr[0], '/');
    }

    /** @param string|array $middlewares */
    public function setAutoMiddlewares($middlewares = [])
    {
        $this->autoMiddlewares = $middlewares;
    }

    private function setupAutoMiddlewares(RoutingPath $routingPath)
    {
        $routingPath->middleware($this->autoMiddlewares);
    }
}