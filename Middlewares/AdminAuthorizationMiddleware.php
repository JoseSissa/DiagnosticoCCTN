<?php

namespace Middlewares;

use Infinitesimal\Auth\AuthorizationMiddleware;

class AdminAuthorizationMiddleware extends AuthorizationMiddleware
{
    protected function requiredAuthorizations(): array
    {
        return ['admin'];
    }
}