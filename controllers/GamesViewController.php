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

    public function search()
    {
        $games = [];

        // Si j'ai du GET, je vais chercher les games
        if (Router::check('name')) {
            $name = Router::get('name', 'is_string');
            $publisherId = Router::get('publisher_id', 'is_numeric');
            $familyId = Router::get('family_id', 'is_numeric');
            $platformId = Router::get('platform_id', 'is_numeric');
            $note = Router::get('note', 'is_numeric');

            // Je recherche
            $games = $this->Game->search(
                $name,
                [
                    'publisher_id' => $publisherId,
                    'family_id' => $familyId,
                    'platform_id' => $platformId,
                    'note' =>  $note
                ]
            );
        }
        
        return [
            // Résultats de recherche
            'games' => $games,

            // Pour la recherche
            'publishers' => $this->Game->Publisher->getList(),
            'families' => $this->Game->Family->getList(),
            'platforms' =>  $this->Game->Platform->getList(),

            // Infos de base
            'title' => 'Recherche',
            'description' => 'Chercher un jeu dans la base de données'
        ];
    }
}