<?php

namespace Infinitesimal\Auth;

class User
{
    /** @var string */
    private $username;

    /** @var string[] */
    private $authorizations;

    public function __construct(string $username, array $authorizations)
    {
        $this->username = $username;
        $this->authorizations = $authorizations;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function isAuthorized(string $authorization): bool
    {
        return in_array($authorization, $this->authorizations);
    }

}