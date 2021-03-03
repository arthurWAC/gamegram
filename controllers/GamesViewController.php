<?php
class GamesViewController extends Controller
{
    public $Game;
    
    public function __construct()
    {
        parent::__construct();
        $this->Game = new Game;
    }

    public function accueil()
    {
        return [
            'title' => 'Accueil',
            'description' => 'Un tout nouveau réseau social centré sur l\'univers des jeux-vidéos Multijoueurs !'
        ];
    }

    public function presentation()
    {
        return [
            'title' => 'Présentation',
            'description' => 'Présentation de ' . NAME_APPLICATION
        ];
    }

    // Je regarde "tous" les jeux
    public function all()
    {
        return [
            'listOfGames' => $this->Game->listOfPublicGames(),
            'title' => 'Jeux',
            'description' => 'Les jeux de ' . NAME_APPLICATION
        ];
    }

    // Je regarde "un" jeu
    public function one()
    {
        $this->Game->populate(
            Router::get('id', 'is_numeric')
        );

        if (!$this->Game->exist()) {
            $this->Alert->setAlert('Ce jeu n\'existe pas');
            $this->Alert->redirect(['dir' => 'games', 'page' => 'jeux']);
        }

        return [
            'jeu' => $this->Game,
            'title' => $this->Game->name,
            'description' => 'Présentation de ' . $this->Game->name
        ];
    }
}