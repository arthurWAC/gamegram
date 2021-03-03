<?php
class UsersViewController extends Controller
{
    public $User;
    
    public function __construct()
    {
        parent::__construct();
        $this->User = new User;
    }

    public function inscription()
    {
        $this->notAllowIfLogged();

        return [
            'title' => 'Inscription',
            'description' => 'Rejoins ce nouveau réseau social'
        ];
    }

    public function connexion()
    {
        $this->notAllowIfLogged();

        return [
            'title' => 'Connexion',
            'description' => 'Accède à ton compte'
        ];
    }

    public function profil()
    {
        $this->notAllowIfNotLogged();

        return [
            'title' => 'Mon profil',
            'description' => 'Modification de mes informations personnelles'
        ];
    }
}