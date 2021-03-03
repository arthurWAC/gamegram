<?php
class PostsViewController extends Controller
{
    public $Post;
    
    public function __construct()
    {
        parent::__construct();
        $this->Post = new Post;

        // Tout doit être sécurisé
        $this->notAllowIfNotLogged();
    }

    public function feed()
    {
        return [
            'posts' => $this->Post->lastPostsWithGameAndUser(),
            'title' => 'Feed',
            'description' => 'Derniers posts de '. NAME_APPLICATION .' !'
        ];
    }

    // Anciennement "post"
    public function one()
    {
        $this->Post->populate(
            Router::get('id', 'is_numeric')
        );

        if (!$this->Post->exist()) {
            $this->Alert->setAlert('Ce Post n\'existe pas');
            $this->Alert->redirect(['dir' => 'posts', 'page' => 'feed']);
        }

        $this->Post->loadComments(10);

        return [
            'post' => $this->Post,
            'title' => $this->Post->title,
            'description' => substr($this->Post->content, 0, 240) . '...'
        ];
    }

    // Anciennement "new_post"
    public function create()
    {
        return [
            // 'gamesById' => (new Game)->publicGamesById(),
            'gamesById' => $this->Post->Game->publicGamesById(),
            'title' => '+ Post',
            'description' => 'Nouveau Post pour '. NAME_APPLICATION .' !'
        ];
    }

    // Anciennement "feed_user"
    public function user()
    {
        $userId = Router::get('id', 'is_numeric');
        $member = new User($_GET['id']);
        
        if (!$member->exist()) {
            $this->Alert->setAlert('Ce Feed n\'existe pas');
            $this->Alert->redirect(['dir' => 'posts', 'page' => 'feed']);
        }

        $member->loadLastPostsAndComments();

        return [
            'member' => $member,
            'title' => $member->pseudo,
            'description' => 'Posts et Commentaires de ' . $member->pseudo
        ];
    }
}