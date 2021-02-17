<?php
class GamesController extends Controller
{
    public $Game;
    
    public function __construct()
    {
        parent::__construct();
        $this->Game = new Game;
    }

    public function view_accueil()
    {
        return [
            'title' => 'Accueil',
            'description' => 'Un tout nouveau réseau social centré sur l\'univers des jeux-vidéos Multijoueurs !'
        ];
    }

    public function view_presentation()
    {
        return [
            'title' => 'Présentation',
            'description' => 'Présentation de ' . NAME_APPLICATION
        ];
    }

    public function view_jeux()
    {
        return [
            'listOfGames' => $this->Game->listOfPublicGames(),
            'title' => 'Jeux',
            'description' => 'Les jeux de ' . NAME_APPLICATION
        ];
    }

    // public function process_
}