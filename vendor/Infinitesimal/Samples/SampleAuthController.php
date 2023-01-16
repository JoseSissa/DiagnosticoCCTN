<?php

namespace Infinitesimal\Samples;

use Infinitesimal\Auth\Authentication;
use Infinitesimal\Auth\AuthenticationException;
use Infinitesimal\Database\SqliteDatabase;
use Infinitesimal\Input;
use Infinitesimal\Url;

class SampleAuthController
{
    private $database;
    private $authentication;

    public function __construct(SqliteDatabase $database, Authentication $authentication)
    {
        $this->database = $database;
        $this->authentication = $authentication;
    }

    public function login()
    {
        try
        {
            $inputs = Input::AnyMulti("username, password");
            $this->authentication->login($inputs['username'], $inputs['password']);
            $this->redirectAfterLogIn();
        }
        catch (AuthenticationException $ex)
        {
            $this->logout();
        }
    }

    private function redirectAfterLogIn()
    {
        if ($this->authentication->getLoggedUser()->isAuthorized('admin'))
            Url::redirect('/adminPanel');
        else
            Url::redirect('/userPanel');
    }

    public function logout()
    {
        $this->authentication->logout();
        Url::redirect('/login');
    }
}