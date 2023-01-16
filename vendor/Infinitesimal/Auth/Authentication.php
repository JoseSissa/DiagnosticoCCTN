<?php

namespace Infinitesimal\Auth;

use Model\Database;

class Authentication
{
    private const SESSION_KEY = 'user';
    private $database;

	public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function login($username, $password)
    {
		$username = mysqli_real_escape_string($this->database->getConn(), $username);
		$password = mysqli_real_escape_string($this->database->getConn(), $password);
		$row = $this->database->getConn()->query("SELECT id, nombre_usuario, clave FROM usuarios WHERE nombre_usuario='$username' AND clave=MD5('$password')")->fetch_assoc();
		
		if ($row != null) {
		
			$id = $row['id']; // Use casing from database.
			$username = $row['nombre_usuario']; // Use casing from database.
			//$hash = $row['clave'];

			//if (password_verify($password, $hash))
			//if ($password == $hash)
			
			$this->setAsLoggedIn($username, $id);
			
        }
        else
        {
            throw new AuthenticationException();
        }
    }

    public function logout()
    {
        unset($_SESSION[self::SESSION_KEY]);
    }

    private function setAsLoggedIn($username, $id)
    {
        $authorizations = $this->getUserAuthorizations($id);
        $user = new User($username, $authorizations);
        $_SESSION[self::SESSION_KEY] = $user;
    }

    private function getUserAuthorizations($id)
    {
		$id = mysqli_real_escape_string($this->database->getConn(), $id);
        $authorizations = [];
		$rows = $this->database->getConn()->query("SELECT autorizacion FROM usuarios_autorizaciones WHERE id_usuario=$id")->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) $authorizations[] = $row['autorizacion'];
        return $authorizations;
    }

    public function getLoggedUser(): ?User
    {
        $user = $_SESSION[self::SESSION_KEY] ?? null;
        if ($user === null || !is_a($user, User::class)) return null;
        return $user;
    }

    public function isAuthenticated(): bool
    {
        return $this->getLoggedUser() !== null;
    }
}