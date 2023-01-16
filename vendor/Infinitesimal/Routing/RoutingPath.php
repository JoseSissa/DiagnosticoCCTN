<?php

namespace Infinitesimal\Routing;

use Infinitesimal\Container;
use Infinitesimal\Middleware\Middleware;
use Infinitesimal\Url;
use function Infinitesimal\view;

class RoutingPath implements RoutingPathConfig, ExecutableRoutingPath, RoutingPathRegistering
{
    /** @var callable */
    private $function;

    private $middlewares = [];

    public function view(string $view): RoutingPathRegistering
    {
        $this->function = function () use ($view)
        {
            view($view);
        };
        return $this;
    }

    public function controller(string $controllerClass, string $method): RoutingPathRegistering
    {
        $this->function = function () use ($controllerClass, $method)
        {
            Container::get($controllerClass)->$method();
        };
        return $this;
    }

    public function run($function): RoutingPathRegistering
    {
        $this->function = $function;
        return $this;
    }

    public function redirect(string $route): RoutingPathRegistering
    {
        $this->function = function () use ($route)
        {
            Url::redirect($route);
        };
        return $this;
    }

    public function execute()
    {
        $middlewaresSuccess = $this->executeMiddlewares($this->middlewares);
        if ($middlewaresSuccess) $this->executeBypassingMiddlewares();
    }

    private function executeMiddlewares(array $middlewares): bool
    {
        foreach ($middlewares as $middlewareClass)
        {
            /** @var Middleware $middleware */
            $middleware = Container::get($middlewareClass);
            $middlewareSuccess = $middleware->run();
            if (!$middlewareSuccess) return false;
        }
        return true;
    }

    public function executeBypassingMiddlewares()
    {
        call_user_func($this->function);
    }

    /** @param string|array $middlewares */
    public function middleware($middlewares)
    {
        if (is_array($middlewares))
            $this->middlewares = $middlewares;
        else
            $this->middlewares = [$middlewares];
    }
}