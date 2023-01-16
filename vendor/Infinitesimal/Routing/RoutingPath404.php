<?php

namespace Infinitesimal\Routing;

class RoutingPath404 extends RoutingPath
{
    public function run($function): RoutingPathRegistering
    {
        http_response_code(404);
        return parent::run($function);
    }
}