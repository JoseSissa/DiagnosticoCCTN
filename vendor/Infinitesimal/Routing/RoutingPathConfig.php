<?php

namespace Infinitesimal\Routing;

interface RoutingPathConfig
{
    public function view(string $view): RoutingPathRegistering;

    public function controller(string $controllerClass, string $method): RoutingPathRegistering;

    public function run($function): RoutingPathRegistering;

    public function redirect(string $route): RoutingPathRegistering;
}