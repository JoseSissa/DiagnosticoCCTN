<?php

namespace Infinitesimal\Auth;

use Infinitesimal\Middleware\Middleware;
use Infinitesimal\Url;

class AuthMiddleware implements Middleware
{
    private $notAuthRedirectUrl;
    private $authentication;

    public function __construct(Authentication $authentication, string $notAuthRedirectUrl = null)
    {
        $this->notAuthRedirectUrl = $notAuthRedirectUrl;
        $this->authentication = $authentication;
    }

    public function run(): bool
    {
        if ($this->authentication->isAuthenticated())
        {
            return true;
        }
        else
        {
            http_response_code(403);
            if ($this->notAuthRedirectUrl !== null) Url::redirect($this->notAuthRedirectUrl);
            return false;
        }
    }
}