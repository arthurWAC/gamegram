<?php
class UsersController extends Controller
{
    public $User;
    
    public function __construct()
    {
        parent::__construct();
        $this->User = new User;
    }

    public function view_inscription()
    {
        $this->notAllowIfLogged();

        return [
            'title' => 'Inscription',
            'description' => 'Rejoins ce nouveau réseau social'
        ];
    }

    public function view_connexion()
    {
        $this->notAllowIfLogged();

        return [
            'title' => 'Connexion',
            'description' => 'Accède à ton compte'
        ];
    }
}