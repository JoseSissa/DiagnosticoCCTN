<?php

namespace Controllers;

use Infinitesimal\Auth\Authentication;
use Infinitesimal\Auth\AuthenticationException;
use Infinitesimal\Input;
use Infinitesimal\Url;
use Model\Database;

class AuthController
{
    private $database;
    private $authentication;

    public function __construct(Database $database, Authentication $authentication)
    {
        $this->database = $database;
        $this->authentication = $authentication;
    }

    public function login()
    {
        try
        {
			$inputs = Input::AnyMulti("usuario, clave");
            $this->authentication->login(htmlspecialchars($inputs['usuario'], ENT_QUOTES), htmlspecialchars($inputs['clave'], ENT_QUOTES));
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
            Url::redirect('/panel_admin');
        else
            Url::redirect('/login');
    }
	
	public function redirectAdmin()
    {
		if ($this->authentication->getLoggedUser() != null)
			if ($this->authentication->getLoggedUser()->isAuthorized('admin'))
				Url::redirect('/panel_admin');
			else
				Url::redirect('/login');
		else
			Url::redirect('/login');
    }

    public function logout()
    {
        $this->authentication->logout();
        Url::redirect('/login');
    }
}