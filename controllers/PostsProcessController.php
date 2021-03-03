<?php
class PostsProcessController extends Controller
{
    public $Post;
    
    public function __construct()
    {
        parent::__construct();
        $this->Post = new Post;

        // Tout doit être sécurisé
        $this->notAllowIfNotLogged();
    }

    public function nouveauPost()
    {
        $validator = new Validator($_POST, 'new_post.php');
        $validator->validateLength('title', 10);
        $validator->validateLength('content', 30);
        $validator->validateNumeric('game_id');
        $data = $validator->getData();

        $this->Post->create(
            $this->Auth->User->id, // Accès direct ici au User.id
            $data['game_id'],
            $data['title'],
            $data['content']
        );

        $this->Alert->setAlert('Post créé avec succès !', ['color' => SUCCESS]);
        $this->Alert->redirect(['dir' => 'posts', 'page' => 'feed']);
    }
}