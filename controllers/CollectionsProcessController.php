<?php
class CollectionsProcessController extends Controller
{
    public $Collection;
    
    public function __construct()
    {
        parent::__construct();
        $this->Collection = new Collection;

        // Tout doit être sécurisé
        $this->notAllowIfNotLogged();
    }

    public function addToCollection()
    {
        $validator = new Validator($_POST, ['dir' => 'games', 'page' => 'search']);
        $validator->validateNumeric('game_id');
        $validator->validateExist('game_id', 'games.id');

        $data = $validator->getData();
        $urlToRedirect = $_SERVER['HTTP_REFERER'];

        if ($this->Collection->alreadyCollected($data['game_id'], $this->Auth->User->id)) {
            $this->Alert->setAlert('Ce Jeu est déjà dans ta collection !', ['color' => DANGER]);
            $this->Alert->redirect(['url' => $urlToRedirect]);
        }

        $this->Collection->create(
            $data['game_id'],
            $this->Auth->User->id,
        );

        $this->Alert->setAlert('Jeu collectionné', ['color' => SUCCESS]);
        $this->Alert->redirect(['url' => $urlToRedirect]);
    }
}