<?php

namespace Infinitesimal\Auth;

abstract class AuthorizationMiddleware
{
    private $authentication;

    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function run(): bool
    {
        $user = $this->authentication->getLoggedUser();

        if ($user === null || !$this->isAuthorized($user))
        {
            http_response_code(403);
            return false;
        }

        return true;
    }

    private function isAuthorized(User $user)
    {
        foreach ($this->requiredAuthorizations() as $requiredAuthorization)
        {
            if (!$user->isAuthorized($requiredAuthorization)) return false;
        }
        return true;
    }

    /** @return string[] */
    protected abstract function requiredAuthorizations(): array;
}