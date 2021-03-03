<?php
class LikesProcessController extends Controller
{
    public $Like;
    
    public function __construct()
    {
        parent::__construct();
        $this->Like = new Like;

        // Tout doit être sécurisé
        $this->notAllowIfNotLogged();
    }

    public function nouveauLike()
    {
        $validator = new Validator($_POST, ['dir' => 'posts', 'page' => 'feed']);
        $validator->validateNumeric('post_id');
        $validator->validateExist('post_id', 'posts.id');

        $data = $validator->getData();
        $urlToRedirect = $_SERVER['HTTP_REFERER'] . '#post_' . $data['post_id'];

        // Rajouté un controle sur le fait que le post soit déjà liké ?
        if ($this->Like->alreadyLike($data['post_id'], $this->Auth->User->id)) {
            $this->Alert->setAlert('Ce Post est déjà liké', ['color' => DANGER]);
            $this->Alert->redirect(['url' => $urlToRedirect]);
        }

        $this->Like->create(
            $data['post_id'],
            $this->Auth->User->id, // Accès direct ici au User.id
        );

        $this->Alert->setAlert('Post liké', ['color' => SUCCESS]);
        $this->Alert->redirect(['url' => $urlToRedirect]);
    }

    public function unlike()
    {
        $validator = new Validator($_POST, 'feed.php');
        $validator->validateNumeric('post_id');
        $data = $validator->getData();

        $this->Like->unlike(
            $data['post_id'],
            $this->Auth->User->id, // Accès direct ici au User.id
        );

        $this->Alert->setAlert('Post Unliké', ['color' => SUCCESS]);
        $urlToRedirect = $_SERVER['HTTP_REFERER'] . '#post_' . $data['post_id'];
        $this->Alert->redirect(['url' => $urlToRedirect]);
    }
}