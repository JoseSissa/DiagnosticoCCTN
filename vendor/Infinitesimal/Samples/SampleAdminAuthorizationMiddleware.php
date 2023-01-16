<?php

namespace Infinitesimal\Samples;

use Infinitesimal\Auth\AuthorizationMiddleware;

class AdminAuthorizationMiddleware extends AuthorizationMiddleware
{
    protected function requiredAuthorizations(): array
    {
        return ['admin'];
    }
}