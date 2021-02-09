<?php
class Game extends ORM
{
    public $Platform;
    public $Publisher;
    public $Family;

    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTable('games');

        if ($id != null) {
            $this->populate($id);
        }
    }
    
    // Méhodes spécifiques à ce modèle
    public function listOfPublicGames()
    {
        $this->setSelectFields('id', 'name', 'year', 'note');
        $this->addWhereFields('public', 1);
        $this->addOrder('name');
        // $this->addOrder('', 'RAND()'); // ORDER BY RAND()

        return $this->get('all');
    }

    public function publicGamesById()
    {
        $publicGames = $this->listOfPublicGames();
        $gamesById = [];

        foreach ($publicGames as $game) {
            $gamesById[$game->id] = $game->name;
        }

        return $gamesById;
    }

    // Méthode du coeur du système
    public function populate($id)
    {
        if (parent::populate($id)) {
            // Si j'arrive à "garnir" Game, je peux alors "garnir"
            // les modèles associés
            $this->Platform = new Platform($this->platform_id);
            $this->Publisher = new Publisher($this->publisher_id);
            $this->Family = new Family($this->family_id);
        }
    }
}