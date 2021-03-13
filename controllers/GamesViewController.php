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
        $this->notAllowIfNotLogged();

        $games = [];

        // Valeurs par défaut pour le formulaire de recherche
        $name = '';
        $publisherId = 0;
        $familyId = 0;
        $platformId = 0;
        $note = 0;
        $search = false; // Est ce que j'ai fait une recherche ?

        // Si j'ai du GET, je vais chercher les games
        if (Router::check('name')) {
            $search = true;

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

            // Pour initialiser le formulaire
            'search_name' => $name,
            'search_publisher_id' => $publisherId,
            'search_family_id' => $familyId,
            'search_platform_id' => $platformId,
            'search_note' => $note,

            // Collection de l'utilisateur connecté
            // (new Collection) au lieu de $this->Collection = new Collection;
            'collection' => (new Collection)->collectionOfUser($this->Auth->User->id),

            // Infos de base
            'title' => 'Recherche',
            'description' => 'Chercher un jeu dans la base de données'
        ];
    }

    // Suggestion / Recommandation / Découverte
    public function suggest()
    {
        $this->notAllowIfNotLogged();
        $games = [];
        // Comment je peux suggérer des jeux ?
            // Collections
            
            // Posts
            // Likes
            // Comments // "C'est nul" => Je dois pas recommander ce genre de jeu

            // Exemple :
                // 8 jeux qui ressemblent aux autres
                // 2 jeux qui n'y ressemblent pas du tout
        
        // Générer des paquets de jeux selon certains critères
        // array_merge, array_intersect, 
        // Dédoublonner
        // array_unique

        // Je prends tous les jeux de sa collection,
        // Je proportionne les familles
            // 20% de FPS
            // 50% de RPG
            // 2% de Sims
            // 28% Aventure
        // Tout ce qui est sous 25% vous suggérez pas
        

        return [
            'games' => $games,
            'title' => 'Suggestions de jeux',
            'description' => 'Chercher un jeu dans la base de données'
        ];
    }
}