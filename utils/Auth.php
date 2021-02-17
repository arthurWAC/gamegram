<?php
class Auth
{
    public $User;
    public $logged = false;

    public function __construct()
    {
        // A la construction de l'objet
        // S'il y a un user_id stocké en session,
        // Je set mon User complet
        if (isset($_SESSION[SESSION_USER_ID])) {
            $this->setUser($_SESSION[SESSION_USER_ID]);
        }
    }

    public function setUser($idUser)
    {
        $this->User = new User($idUser);
        $this->logged = true;

        $_SESSION[SESSION_USER_ID] = $idUser;
    }

    public function logout()
    {
        $this->logged = false;
        unset($_SESSION[SESSION_USER_ID]);
        unset($this->User);
    }
}